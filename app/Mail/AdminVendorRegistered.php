<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Vendeur;

class AdminVendorRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Vendeur $vendeur) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau vendeur inscrit en attente',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-vendor-registered',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
