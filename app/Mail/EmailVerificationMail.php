<?php

namespace App\Mail;

use App\Models\Vendeur;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Vendeur $vendeur,
        public string $verificationUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vérifiez votre adresse email — ' . config('platform.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email-verification',
            text: 'emails.email-verification-text',
            with: [
                'vendeur' => $this->vendeur,
                'verificationUrl' => $this->verificationUrl,
            ],
        );
    }
}
