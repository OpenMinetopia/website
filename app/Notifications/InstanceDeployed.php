<?php

namespace App\Notifications;

use App\Models\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstanceDeployed extends Notification
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
            ->subject('Your Instance Has Been Deployed')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your instance has been deployed successfully.')
            ->line('Portal URL: https://' . $this->instance->hostname)
            ->action('View Instance', route('instances.show', $this->instance))
            ->line('You can now access your portal using the link above.');
    }
} 