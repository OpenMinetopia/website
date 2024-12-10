<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;

class SubscriptionRenewalReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Subscription $subscription,
        protected int $daysLeft
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $message = match($this->daysLeft) {
            7 => "Je abonnement verloopt binnen 7 dagen",
            2 => "Je abonnement verloopt binnen 2 dagen",
            0 => "Je abonnement verloopt vandaag",
            default => "Je abonnement verloopt binnenkort"
        };

        return (new MailMessage)
            ->subject($message)
            ->greeting('Hallo ' . $notifiable->name)
            ->line($message . '.')
            ->line('Portal: ' . $this->subscription->instance->hostname)
            ->line('Verloopdatum: ' . $this->subscription->ends_at->format('F j, Y'))
            ->action('Nu verlengen', route('instances.show', $this->subscription->instance))
            ->line('Houd er rekening mee dat betalingen tot 24 uur kunnen duren')
            ->line('Als je niet op tijd verlengt, word je portaal gesuspend.');
    }
}
