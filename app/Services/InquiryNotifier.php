<?php

namespace App\Services;

use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class InquiryNotifier
{
    public function send(Inquiry $inquiry): bool
    {
        return Cache::lock('inquiry-notification:'.$inquiry->id, 120)->get(function () use ($inquiry): bool {
            $inquiry->refresh();

            if ($inquiry->notification_sent_at !== null) {
                return true;
            }

            try {
                Mail::to(config('mail.inquiry_to'))->send(new InquiryReceived($inquiry));
            } catch (TransportExceptionInterface $exception) {
                Log::warning('Contact notification could not be sent.', [
                    'inquiry_id' => $inquiry->id,
                    'exception' => $exception::class,
                ]);

                return false;
            }

            $inquiry->notification_sent_at = now();
            $inquiry->save();

            return true;
        });
    }
}
