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
            ->subject('Jouw portal is actief')
            ->greeting('Hallo ' . $notifiable->name)
            ->line('Goed nieuws, jouw portal is actief en kan gebruikt worden!')
            ->line('Je kan jouw portal bereiken via: https://' . $this->instance->hostname)
            ->action('Bekijk instance', route('instances.show', $this->instance))
            ->line('Vragen? Neem gerust contact met ons op!');
    }
}
