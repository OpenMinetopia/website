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
        // Notify user
        $instance->user->notify(new InstanceCreated($instance));

        // Notify admins via Filament Database Notification
        User::where('is_admin', true)->each(function ($admin) use ($instance) {
            FilamentNotification::make()
                ->title('New Instance Created')
                ->icon('heroicon-o-server')
                ->iconColor('info')
                ->body("A new instance ({$instance->hostname}) was created by {$instance->user->name}")
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
                'title' => '🆕 New Instance Created',
                'description' => "A new instance has been created.",
                'color' => hexdec('5865F2'), // Discord blue
                'fields' => [
                    [
                        'name' => 'Portal URL',
                        'value' => "https://{$instance->hostname}",
                        'inline' => true
                    ],
                    [
                        'name' => 'Created By',
                        'value' => $instance->user->name,
                        'inline' => true
                    ],
                    [
                        'name' => 'Subscription',
                        'value' => $instance->subscriptions->first() ? 
                            str_replace('_', ' ', ucfirst($instance->subscriptions->first()->duration)) : 
                            'No subscription yet',
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
                    ->title('Instance Activated')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')
                    ->body("Instance {$instance->hostname} has been activated")
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
                    'title' => '⚠️ Instance Suspended',
                    'description' => "An instance has been suspended.",
                    'color' => hexdec('ED4245'), // Discord red
                    'fields' => [
                        [
                            'name' => 'Portal URL',
                            'value' => "https://{$instance->hostname}",
                            'inline' => true
                        ],
                        [
                            'name' => 'Owner',
                            'value' => $instance->user->name,
                            'inline' => true
                        ],
                        [
                            'name' => 'Reason',
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
                    ->body("Instance {$instance->hostname} has been deployed successfully")
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
                    'title' => '🚀 Instance Deployed',
                    'description' => "An instance has been deployed.",
                    'color' => hexdec('57F287'), // Discord green
                    'fields' => [
                        [
                            'name' => 'Portal URL',
                            'value' => "https://{$instance->hostname}",
                            'inline' => true
                        ],
                        [
                            'name' => 'Owner',
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