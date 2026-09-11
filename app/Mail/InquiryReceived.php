<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class InquiryReceived extends Mailable
{
    public function __construct(public Inquiry $inquiry) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            replyTo: [new Address($this->inquiry->email, preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->inquiry->name))],
            subject: 'DETRA — Nouvelle demande '.sprintf('DTR-%06d', $this->inquiry->id),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.inquiries.received',
            text: 'mail.inquiries.received-text',
            with: [
                'reference' => sprintf('DTR-%06d', $this->inquiry->id),
                'service' => __('site.form.services.'.$this->inquiry->service, [], 'fr'),
            ],
        );
    }
}
