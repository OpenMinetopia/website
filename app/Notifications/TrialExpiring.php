<?php

namespace App\Notifications;

use App\Models\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrialExpiring extends Notification
{
    use Queueable;

    public function __construct(protected Instance $instance)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Je proefperiode verloopt bijna')
            ->greeting('Hallo ' . $notifiable->name)
            ->line('Je proefperiode voor ' . $this->instance->hostname . ' verloopt over 2 dagen.')
            ->line('Om je portal actief te houden, raden we je aan om nu je proefperiode om te zetten naar een betaald abonnement.')
            ->action('Proefperiode omzetten', route('instances.show', $this->instance))
            ->line('Als je geen actie onderneemt, wordt je portal gedeactiveerd wanneer de proefperiode afloopt.');
    }
} 