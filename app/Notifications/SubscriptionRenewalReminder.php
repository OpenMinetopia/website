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
            7 => "Your subscription will expire in 7 days",
            2 => "Your subscription will expire in 2 days",
            0 => "Your subscription expires today",
            default => "Your subscription will expire soon"
        };

        return (new MailMessage)
            ->subject($message)
            ->greeting('Hello ' . $notifiable->name)
            ->line($message . '.')
            ->line('Instance: ' . $this->subscription->instance->hostname)
            ->line('Expiration date: ' . $this->subscription->ends_at->format('F j, Y'))
            ->action('Renew Now', route('instances.show', $this->subscription->instance))
            ->line('Please note that payments can take up to 24 hours to process.')
            ->line('If you do not renew in time, your instance will be suspended.');
    }
} 