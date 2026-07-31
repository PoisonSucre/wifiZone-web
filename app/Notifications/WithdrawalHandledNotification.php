<?php

namespace App\Notifications;

use App\Models\Admin;
use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalHandledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Withdrawal $withdrawal,
        public Admin $admin,
        public string $action
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Retrait #' . $this->withdrawal->id . ' traité par ' . $this->admin->fullName())
            ->view('emails.withdrawal-handled-admin', [
                'admin' => $this->admin,
                'vendeur' => $this->withdrawal->vendeur,
                'withdrawal' => $this->withdrawal,
                'action' => $this->action,
            ]);
    }
}
