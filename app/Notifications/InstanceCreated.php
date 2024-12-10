<?php

namespace App\Notifications;

use App\Models\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstanceCreated extends Notification
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
            ->subject('Your Instance Has Been Created')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your instance has been created successfully.')
            ->line('Portal URL: ' . $this->instance->hostname)
            ->action('View Instance', route('instances.show', $this->instance))
            ->line('Please complete the payment and DNS configuration to activate your instance.');
    }
} 