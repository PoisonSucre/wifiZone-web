<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalRequestedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Withdrawal $withdrawal) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $vendeur = $this->withdrawal->vendeur;

        return (new MailMessage)
            ->subject('Nouvelle demande de retrait de ' . $vendeur->fullName())
            ->view('emails.withdrawal-requested', [
                'admin' => $notifiable,
                'vendeur' => $vendeur,
                'withdrawal' => $this->withdrawal,
            ]);
    }
}
