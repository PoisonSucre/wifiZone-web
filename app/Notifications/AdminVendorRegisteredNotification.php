<?php

namespace App\Notifications;

use App\Models\Vendeur;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminVendorRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Vendeur $vendeur) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau vendeur inscrit en attente')
            ->view('emails.admin-vendor-registered', ['vendeur' => $this->vendeur]);
    }
}
