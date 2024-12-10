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
            ->subject('Je portal is bijgewerkt')
            ->greeting('Hallo ' . $notifiable->name)
            ->line('We hebben net jouw portaal gedeployed naar een nieuwe versie.')
            ->line('Portal URL: https://' . $this->instance->hostname)
            ->action('Bekijk instance', route('instances.show', $this->instance))
            ->line('Je hoeft verder niets te doen.');
    }
}
