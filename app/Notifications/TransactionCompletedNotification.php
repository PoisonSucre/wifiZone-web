<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Transaction $transaction,
        public ?Ticket $ticket = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Paiement reçu - ' . number_format($this->transaction->montant, 0, ',', ' ') . ' ' . config('platform.currency'))
            ->view('emails.transaction-completed', [
                'vendeur' => $notifiable,
                'transaction' => $this->transaction,
                'ticket' => $this->ticket,
            ]);

        return $mail;
    }
}
