<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Vendeur;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransactionCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Transaction $transaction,
        public ?Ticket $ticket = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Paiement reçu - ' . number_format($this->transaction->montant, 0, ',', ' ') . ' ' . config('platform.currency'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction-completed',
            with: [
                'transaction' => $this->transaction,
                'ticket' => $this->ticket,
            ],
        );
    }
}
