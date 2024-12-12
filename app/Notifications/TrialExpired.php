<?php

namespace App\Notifications;

use App\Models\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrialExpired extends Notification
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
            ->subject('Je proefperiode is verlopen')
            ->greeting('Hallo ' . $notifiable->name)
            ->line('Je proefperiode voor ' . $this->instance->hostname . ' is verlopen.')
            ->line('Je portal is gedeactiveerd. Om deze weer te activeren, kun je alsnog upgraden naar een betaald abonnement.')
            ->action('Upgraden naar betaald abonnement', route('instances.show', $this->instance))
            ->line('Bedankt voor het uitproberen van onze dienst!');
    }
} 