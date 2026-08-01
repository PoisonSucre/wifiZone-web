<?php

namespace App\Mail;

use App\Models\HotspotSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HotspotPackConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public HotspotSubscription $subscription;

    public function __construct(HotspotSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Abonnement hotspots confirmé',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hotspot-pack-confirmed',
        );
    }
}
