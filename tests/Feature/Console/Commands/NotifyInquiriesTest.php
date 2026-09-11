<?php

use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use App\Services\InquiryNotifier;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\Support\FailingMailTransport;

uses(LazilyRefreshDatabase::class);

function pendingMailInquiry(): Inquiry
{
    return Inquiry::create([
        'name' => 'Marie Test', 'email' => 'marie@example.test', 'service' => 'supply',
        'message' => 'Livraison de gasoil à Kinshasa pour notre entreprise.', 'locale' => 'fr', 'consented_at' => now(),
    ]);
}

test('retries only pending notifications without sending an already notified enquiry again', function () {
    config(['mail.default' => 'smtp']);
    Mail::fake();
    $sent = pendingMailInquiry();
    $sent->notification_sent_at = now();
    $sent->save();
    $pending = pendingMailInquiry();

    $this->artisan('detra:inquiries:notify')->assertSuccessful();

    Mail::assertSent(InquiryReceived::class, fn (InquiryReceived $mail) => $mail->inquiry->is($pending) && $mail->hasTo('sales@detradrc.com'));
    Mail::assertSentCount(1);
    expect($pending->refresh()->notification_sent_at)->not->toBeNull();
});

test('limits a notification retry to the requested pending enquiry', function () {
    config(['mail.default' => 'smtp']);
    Mail::fake();
    $other = pendingMailInquiry();
    $selected = pendingMailInquiry();

    $this->artisan('detra:inquiries:notify', ['--id' => $selected->id])->assertSuccessful();

    Mail::assertSent(InquiryReceived::class, fn (InquiryReceived $mail) => $mail->inquiry->is($selected));
    expect($other->refresh()->notification_sent_at)->toBeNull();
});

test('honours the batch limit while leaving later enquiries pending', function () {
    config(['mail.default' => 'smtp']);
    Mail::fake();
    $first = pendingMailInquiry();
    $later = pendingMailInquiry();

    $this->artisan('detra:inquiries:notify', ['--limit' => 1])->assertSuccessful();

    Mail::assertSent(InquiryReceived::class, fn (InquiryReceived $mail) => $mail->inquiry->is($first));
    expect($later->refresh()->notification_sent_at)->toBeNull();
});

test('does not send a stale enquiry a second time after its notification was recorded', function () {
    Mail::fake();
    $stale = pendingMailInquiry();
    $updated = $stale->fresh();
    $updated->notification_sent_at = now();
    $updated->save();

    $sent = app(InquiryNotifier::class)->send($stale);

    expect($sent)->toBeTrue();
    Mail::assertNothingSent();
});

test('keeps an enquiry pending and returns failure when smtp rejects the retry', function () {
    config(['mail.default' => 'smtp']);
    Mail::mailer()->setSymfonyTransport(new FailingMailTransport);
    $inquiry = pendingMailInquiry();

    $this->artisan('detra:inquiries:notify')->assertFailed();

    expect($inquiry->refresh()->notification_sent_at)->toBeNull();
});

test('does not send a notification while another sender holds its lock', function () {
    config(['mail.default' => 'smtp']);
    Mail::fake();
    $inquiry = pendingMailInquiry();
    $lock = Cache::lock('inquiry-notification:'.$inquiry->id, 120);
    $lock->get();

    try {
        $this->artisan('detra:inquiries:notify')->assertFailed();

        Mail::assertNothingSent();
        expect($inquiry->refresh()->notification_sent_at)->toBeNull();
    } finally {
        $lock->release();
    }
});

test('refuses to mark pending enquiries as sent using a non-smtp transport', function () {
    config(['mail.default' => 'log']);
    Mail::fake();
    $inquiry = pendingMailInquiry();

    $this->artisan('detra:inquiries:notify')->assertFailed();

    Mail::assertNothingSent();
    expect($inquiry->refresh()->notification_sent_at)->toBeNull();
});

test('rejects invalid enquiry identifiers before sending', function () {
    config(['mail.default' => 'smtp']);
    Mail::fake();

    $this->artisan('detra:inquiries:notify', ['--id' => 'invalid'])->assertFailed();

    Mail::assertNothingSent();
});
