<?php

namespace App\Observers;

use App\Models\Instance;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InstanceCreated;
use App\Notifications\InstanceActivated;
use App\Notifications\InstanceDeployed;
use Filament\Notifications\Notification as FilamentNotification;

class InstanceObserver
{
    public function created(Instance $instance)
    {
        // Only send Discord webhook, remove the notification
        Http::post(config('services.discord.webhook_url'), [
            'embeds' => [[
                'title' => '🆕 Nieuw portal aangevraagd',
                'description' => "Er is een nieuw portal aangevraagd. Controleer betaling en handel af",
                'color' => hexdec('5865F2'),
                'fields' => [
                    [
                        'name' => 'Portal URL',
                        'value' => "https://{$instance->hostname}",
                        'inline' => true
                    ],
                    [
                        'name' => 'Aangevraagd door',
                        'value' => $instance->user->name,
                        'inline' => true
                    ],
                    [
                        'name' => 'Abonnemet',
                        'value' => $instance->subscriptions->first() ?
                            str_replace('_', ' ', ucfirst($instance->subscriptions->first()->duration)) :
                            'Nog geen abonnement',
                        'inline' => true
                    ]
                ],
                'url' => route('filament.admin.resources.instances.edit', $instance),
                'timestamp' => now()->toIso8601String()
            ]]
        ]);
    }

    public function updated(Instance $instance)
    {
        // Check if status changed to active
        if ($instance->wasChanged('status') && $instance->status === 'active') {
            $instance->user->notify(new InstanceActivated($instance));

            // Notify admins via Filament Database Notification
            User::where('is_admin', true)->each(function ($admin) use ($instance) {
                FilamentNotification::make()
                    ->title('Portal geactiveerd')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')
                    ->body("Portal {$instance->hostname} is geactiveerd")
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('view')
                            ->button()
                            ->url(route('filament.admin.resources.instances.edit', $instance))
                    ])
                    ->sendToDatabase($admin);
            });
        }

        // Check if status changed to suspended
        if ($instance->wasChanged('status') && $instance->status === 'suspended') {
            // Notify admins via Filament Database Notification
            User::where('is_admin', true)->each(function ($admin) use ($instance) {
                FilamentNotification::make()
                    ->title('Instance Suspended')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->iconColor('danger')
                    ->body("Instance {$instance->hostname} has been suspended.\nReason: {$instance->suspension_reason}")
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('view')
                            ->button()
                            ->url(route('filament.admin.resources.instances.edit', $instance))
                    ])
                    ->sendToDatabase($admin);
            });

            // Discord webhook
            Http::post(config('services.discord.webhook_url'), [
                'embeds' => [[
                    'title' => '⚠️Portal is suspended',
                    'description' => "Er is een portal suspended.",
                    'color' => hexdec('ED4245'), // Discord red
                    'fields' => [
                        [
                            'name' => 'Portal URL',
                            'value' => "https://{$instance->hostname}",
                            'inline' => true
                        ],
                        [
                            'name' => 'Eigenaar',
                            'value' => $instance->user->name,
                            'inline' => true
                        ],
                        [
                            'name' => 'Reden',
                            'value' => $instance->suspension_reason ?? 'No reason provided',
                            'inline' => false
                        ]
                    ],
                    'url' => route('filament.admin.resources.instances.edit', $instance),
                    'timestamp' => now()->toIso8601String()
                ]]
            ]);
        }

        // Check if deployment status changed
        if ($instance->wasChanged('last_deployment_at')) {
            $instance->user->notify(new InstanceDeployed($instance));

            // Notify admins via Filament Database Notification
            User::where('is_admin', true)->each(function ($admin) use ($instance) {
                FilamentNotification::make()
                    ->title('Instance Deployed')
                    ->icon('heroicon-o-rocket-launch')
                    ->iconColor('success')
                    ->body("Portal {$instance->hostname} is zojuist gedeployed!")
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('view')
                            ->button()
                            ->url(route('filament.admin.resources.instances.edit', $instance))
                    ])
                    ->sendToDatabase($admin);
            });

            // Discord webhook
            Http::post(config('services.discord.webhook_url'), [
                'embeds' => [[
                    'title' => '🚀 Portal gedeployed',
                    'description' => "Er is zojuist een portaal gedeployed.",
                    'color' => hexdec('57F287'), // Discord green
                    'fields' => [
                        [
                            'name' => 'Portal URL',
                            'value' => "https://{$instance->hostname}",
                            'inline' => true
                        ],
                        [
                            'name' => 'Eigenaar',
                            'value' => $instance->user->name,
                            'inline' => true
                        ],
                        [
                            'name' => 'Status',
                            'value' => ucfirst($instance->status),
                            'inline' => true
                        ]
                    ],
                    'url' => route('filament.admin.resources.instances.edit', $instance),
                    'timestamp' => now()->toIso8601String()
                ]]
            ]);
        }
    }
}
