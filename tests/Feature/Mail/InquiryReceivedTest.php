<?php

use App\Mail\InquiryReceived;
use App\Models\Inquiry;

test('sends from DETRA with the visitor as reply-to and a reference in the subject', function () {
    config(['mail.from.address' => 'tonymukash@detradrc.com', 'mail.from.name' => 'DETRA SARL']);
    $inquiry = new Inquiry(['name' => "Marie\r\nTest", 'email' => 'marie@example.test', 'service' => 'import', 'locale' => 'fr']);
    $inquiry->id = 42;
    $inquiry->created_at = now();

    $mail = new InquiryReceived($inquiry);

    $mail->assertFrom('tonymukash@detradrc.com', 'DETRA SARL')
        ->assertHasReplyTo('marie@example.test', 'Marie  Test')
        ->assertHasSubject('DETRA — Nouvelle demande DTR-000042');
});

test('renders all enquiry details in html and plain text for both form languages', function (string $locale, string $language) {
    $inquiry = new Inquiry([
        'name' => 'Marie Test', 'company' => 'Énergie & transport', 'email' => 'marie@example.test',
        'phone' => '+243 999 000 000', 'service' => 'import', 'locale' => $locale,
        'message' => "Livraison de gasoil à Kinshasa.\nVolume prévu : 20 000 litres.",
    ]);
    $inquiry->id = 42;
    $inquiry->created_at = '2026-09-11 08:00:00';

    $mail = new InquiryReceived($inquiry);

    foreach (['DTR-000042', 'Marie Test', 'Énergie & transport', 'marie@example.test', '+243 999 000 000', 'Livraison de gasoil à Kinshasa.', '20 000 litres.', '11/09/2026 à 09:00', $language] as $value) {
        $mail->assertSeeInHtml($value)->assertSeeInText($value);
    }
})->with([['fr', 'Français'], ['en', 'Anglais']]);

test('escapes visitor content in html email and preserves it as literal plain text', function () {
    $inquiry = new Inquiry([
        'name' => '<script>alert("name")</script>', 'company' => '<img src=x onerror=alert(1)>',
        'phone' => '<b>123</b>', 'email' => 'marie@example.test', 'service' => 'other', 'locale' => 'fr',
        'message' => '<a href="https://evil.example">Click</a> & le projet',
    ]);
    $inquiry->id = 1;
    $inquiry->created_at = now();

    $mail = new InquiryReceived($inquiry);

    foreach ([$inquiry->name, $inquiry->company, $inquiry->phone, $inquiry->message] as $value) {
        $mail->assertSeeInHtml($value)->assertDontSeeInHtml($value, false)->assertSeeInText($value);
    }
});
