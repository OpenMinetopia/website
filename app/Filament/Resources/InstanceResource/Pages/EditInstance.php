<?php

namespace App\Filament\Resources\InstanceResource\Pages;

use App\Filament\Resources\InstanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Filament\Forms;

class EditInstance extends EditRecord
{
    protected static string $resource = InstanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('deploy')
                ->icon('heroicon-m-rocket-launch')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Deploy Instance')
                ->modalDescription(function () {
                    if (!$this->record->is_paid) {
                        return 'Warning: Instance is not paid. Deploying will not activate the instance.';
                    }
                    if (!$this->record->dns_verified) {
                        return 'Warning: DNS is not verified. Deploying will not activate the instance.';
                    }
                    return 'Are you sure you want to deploy this instance? This will activate the instance and start the subscription period.';
                })
                ->modalSubmitActionLabel('Yes, deploy instance')
                ->form([
                    Forms\Components\Placeholder::make('info')
                        ->content('This will:')
                        ->extraAttributes(['class' => 'text-sm text-gray-500']),
                    Forms\Components\Placeholder::make('points')
                        ->content(view('filament.actions.deploy-points')),
                ])
                ->action(function () {
                    $this->record->update([
                        'deployment_status' => 'completed',
                        'last_deployment_at' => now(),
                    ]);

                    // Only activate and start subscription if requirements are met
                    if ($this->record->is_paid && $this->record->dns_verified) {
                        $this->record->update(['status' => 'active']);

                        if (!$this->record->activeSubscription()) {
                            $subscription = $this->record->subscriptions()->first();
                            if ($subscription) {
                                // Parse the duration and add the correct interval
                                $ends_at = now();
                                $duration = explode('_', $subscription->duration);
                                $amount = (int) $duration[0];
                                
                                $ends_at = match($duration[1]) {
                                    'month', 'months' => $ends_at->addMonths($amount),
                                    'year', 'years' => $ends_at->addYears($amount),
                                    default => $ends_at->addMonths($amount),
                                };

                                $subscription->update([
                                    'starts_at' => now(),
                                    'ends_at' => $ends_at,
                                    'status' => 'paid'
                                ]);
                            }
                        }

                        Notification::make()
                            ->title('Instance Deployed and Activated')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Instance Deployed')
                            ->warning()
                            ->body('Instance was deployed but not activated due to pending requirements.')
                            ->send();
                    }
                }),

            Actions\Action::make('renew')
                ->icon('heroicon-m-arrow-path')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Renew Subscription')
                ->modalDescription('This will renew the subscription for another period. Make sure payment has been received.')
                ->action(function () {
                    $subscription = $this->record->subscriptions()->latest()->first();
                    
                    if (!$subscription) {
                        Notification::make()
                            ->title('No subscription found')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Parse the duration and add the correct interval
                    $ends_at = now();
                    $duration = explode('_', $subscription->duration);
                    $amount = (int) $duration[0];
                    
                    $ends_at = match($duration[1]) {
                        'month', 'months' => $ends_at->addMonths($amount),
                        'year', 'years' => $ends_at->addYears($amount),
                        default => $ends_at->addMonths($amount),
                    };

                    $subscription->update([
                        'starts_at' => now(),
                        'ends_at' => $ends_at,
                        'status' => 'paid'
                    ]);

                    // Also ensure instance is active
                    $this->record->update(['status' => 'active']);

                    Notification::make()
                        ->title('Subscription Renewed')
                        ->success()
                        ->send();
                })
                ->visible(fn () => 
                    $this->record->activeSubscription() && 
                    $this->record->activeSubscription()->ends_at->isPast()
                ),

            Actions\Action::make('suspend')
                ->icon('heroicon-m-pause-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Suspend Instance')
                ->modalDescription('Are you sure you want to suspend this instance? Users will not be able to access it until reactivated.')
                ->form([
                    Forms\Components\Textarea::make('suspension_reason')
                        ->label('Suspension Reason')
                        ->required()
                        ->maxLength(500)
                        ->placeholder('Please provide a reason for suspension'),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'suspended',
                        'suspension_reason' => $data['suspension_reason'],
                        'suspended_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Instance Suspended')
                        ->warning()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'active'),

            Actions\Action::make('reactivate')
                ->icon('heroicon-m-play-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Reactivate Instance')
                ->modalDescription('Are you sure you want to reactivate this instance?')
                ->action(function () {
                    $this->record->update([
                        'status' => 'active',
                        'suspension_reason' => null,
                        'suspended_at' => null,
                    ]);

                    Notification::make()
                        ->title('Instance Reactivated')
                        ->success()
                        ->send();
                })
                ->visible(fn () => $this->record->status === 'suspended'),

            Actions\DeleteAction::make(),
        ];
    }
}
