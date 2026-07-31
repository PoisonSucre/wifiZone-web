<?php

namespace App\Mail;

use App\Models\Admin;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WithdrawalHandledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Withdrawal $withdrawal,
        public Admin $acting,
        public string $action,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Retrait #' . $this->withdrawal->id . ' traité par ' . $this->acting->prenom,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.withdrawal-handled',
            with: [
                'withdrawal' => $this->withdrawal,
                'acting' => $this->acting,
                'action' => $this->action,
            ],
        );
    }
}
