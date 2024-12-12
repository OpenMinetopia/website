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
            ->subject('Je proefperiode is aangevraagd')
            ->greeting('Hallo ' . $notifiable->name)
            ->line('Je portal is aangevraagd met een gratis proefperiode van 7 dagen.')
            ->line('Portal URL: ' . $this->instance->hostname)
            ->action('Bekijk instance', route('instances.show', $this->instance))
            ->line('We gaan direct aan de slag met het opzetten van je portal.')
            ->line('Zorg dat je de DNS/Plugin correct instelt zodat we je portal kunnen activeren.');
    }
}
