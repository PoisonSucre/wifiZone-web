<?php

namespace App\Mail;

use App\Models\Vendeur;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorActivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Vendeur $vendeur) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre compte vendeur a été activé !',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vendor-activated',
            with: ['vendeur' => $this->vendeur],
        );
    }
}
