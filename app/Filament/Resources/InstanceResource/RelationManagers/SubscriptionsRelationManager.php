<?php

namespace App\Filament\Resources\InstanceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';
    protected static ?string $title = 'Subscriptions';
    protected static ?string $recordTitleAttribute = 'duration';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('duration')
                    ->options([
                        '1_month' => '1 Month',
                        '3_months' => '3 Months',
                        '6_months' => '6 Months',
                        '12_months' => '12 Months',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'bank_transfer' => 'Bank Transfer',
                        'paypal' => 'PayPal',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('duration')
                    ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', ucfirst($state))),
                Tables\Columns\TextColumn::make('amount')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', ucfirst($state))),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'failed',
                        'warning' => 'pending',
                        'success' => 'paid',
                        'gray' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record) {
                        // Update instance payment status if subscription is marked as paid
                        if ($record->status === 'paid') {
                            $record->instance->update(['is_paid' => true]);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function ($record) {
                        // Update instance payment status if subscription is marked as paid
                        if ($record->status === 'paid') {
                            $record->instance->update(['is_paid' => true]);
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('renew')
                ->icon('heroicon-m-arrow-path')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Renew Subscription')
                ->modalDescription('This will renew the subscription for another period. Make sure payment has been received.')
                ->action(function ($record) {
                    // Parse the duration and add the correct interval
                    $ends_at = now();
                    $duration = explode('_', $record->duration);
                    $amount = (int) $duration[0];
                    
                    $ends_at = match($duration[1]) {
                        'month', 'months' => $ends_at->addMonths($amount),
                        'year', 'years' => $ends_at->addYears($amount),
                        default => $ends_at->addMonths($amount),
                    };

                    $record->update([
                        'starts_at' => now(),
                        'ends_at' => $ends_at,
                        'status' => 'paid'
                    ]);

                    // Also ensure instance is active
                    $record->instance->update(['status' => 'active']);

                    Notification::make()
                        ->title('Subscription Renewed')
                        ->success()
                        ->send();
                })
                ->visible(fn ($record) => $record->ends_at->isPast()),
            // ... other actions ...
        ];
    }
} 