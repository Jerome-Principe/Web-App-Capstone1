<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecoveryOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Recovery OTP',
            from: new Address('new@limitlessfitnesstudio.com', 'Limitless Fitness Studio'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recovery-email-otp',
            with: [
                'otp' => $this->otp, // match the Blade variable
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
