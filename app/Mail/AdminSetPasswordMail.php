<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminSetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Admin $admin,
        public string $setPasswordUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Création de votre mot de passe administrateur — ' . config('platform.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-set-password',
            with: [
                'admin' => $this->admin,
                'setPasswordUrl' => $this->setPasswordUrl,
            ],
        );
    }
}
