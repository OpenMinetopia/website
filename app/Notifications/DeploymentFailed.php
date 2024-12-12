<?php

namespace App\Notifications;

use App\Models\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeploymentFailed extends Notification
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
            ->subject('Portal deployment mislukt')
            ->greeting('Hallo ' . $notifiable->name)
            ->line('Er is helaas iets misgegaan bij het opzetten van je portal.')
            ->line('Onze technische team is op de hoogte gebracht en zal dit zo snel mogelijk oplossen.')
            ->line('We nemen contact met je op zodra je portal beschikbaar is.')
            ->line('Excuses voor het ongemak!');
    }
} 