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
            ->subject('Je portal is aangeraagd')
            ->greeting('Hallo ' . $notifiable->name)
            ->line('Je portal is aangevraagd.')
            ->line('Portal URL: ' . $this->instance->hostname)
            ->action('Bekijk instance', route('instances.show', $this->instance))
            ->line('Zorg dat je de betaling voldoet en je DNS/Plugin instelt.');
    }
}
