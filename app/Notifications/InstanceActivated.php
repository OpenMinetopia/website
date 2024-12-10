<?php

namespace App\Notifications;

use App\Models\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstanceActivated extends Notification
{
    use Queueable;

    public function __construct(protected Instance $instance) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Instance Is Now Active')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your instance is now active and ready to use.')
            ->line('You can access your portal at: https://' . $this->instance->hostname)
            ->action('View Instance', route('instances.show', $this->instance))
            ->line('Thank you for using our service!');
    }
} 