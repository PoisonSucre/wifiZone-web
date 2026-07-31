<?php

namespace App\Mail;

use App\Models\Vendeur;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorSuspendedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Vendeur $vendeur) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre compte vendeur a été suspendu',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vendor-suspended',
            with: ['vendeur' => $this->vendeur],
        );
    }
}
