<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstanceResource\Pages;
use App\Filament\Resources\InstanceResource\RelationManagers\SubscriptionsRelationManager;
use App\Models\Instance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Notifications\Notification;

class InstanceResource extends Resource
{
    protected static ?string $model = Instance::class;
    protected static ?string $navigationIcon = 'heroicon-o-server';
    protected static ?string $navigationGroup = 'Instance Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        // Main Settings (Left Column - 2 spans)
                        Forms\Components\Group::make()
                            ->columnSpan(2)
                            ->schema([
                                Forms\Components\Section::make('Instance Details')
                                    ->description('Basic instance configuration')
                                    ->icon('heroicon-m-server')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('hostname')
                                                    ->required()
                                                    ->unique(ignoreRecord: true),
                                                Forms\Components\Select::make('status')
                                                    ->options([
                                                        'pending' => 'Pending',
                                                        'active' => 'Active',
                                                        'suspended' => 'Suspended',
                                                        'removed' => 'Removed',
                                                    ])
                                                    ->required(),
                                                Forms\Components\TextInput::make('version')
                                                    ->default('1.20.4'),
                                                Forms\Components\Toggle::make('is_beta')
                                                    ->label('Beta Features'),
                                            ]),
                                    ]),

                                Forms\Components\Section::make('Deployment Status')
                                    ->description('Current deployment information')
                                    ->icon('heroicon-m-rocket-launch')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('deployment_status')
                                                    ->options([
                                                        'pending' => 'Pending',
                                                        'in_progress' => 'In Progress',
                                                        'completed' => 'Completed',
                                                        'failed' => 'Failed',
                                                    ])
                                                    ->disabled(),
                                                Forms\Components\Select::make('ploi_deployment_status')
                                                    ->label('Ploi Status')
                                                    ->options([
                                                        'pending' => 'Pending',
                                                        'creating_site' => 'Creating Site',
                                                        'creating_database' => 'Creating Database',
                                                        'configuring_env' => 'Configuring Environment',
                                                        'installing_repository' => 'Installing Repository',
                                                        'requesting_ssl' => 'Requesting SSL',
                                                        'deploying' => 'Deploying',
                                                        'completed' => 'Completed',
                                                        'failed' => 'Failed'
                                                    ])
                                                    ->disabled(),
                                                Forms\Components\DateTimePicker::make('last_deployment_at')
                                                    ->label('Last Deployed At')
                                                    ->disabled(),
                                                Forms\Components\Textarea::make('ploi_deployment_error')
                                                    ->label('Last Deployment Error')
                                                    ->disabled()
                                                    ->columnSpanFull()
                                                    ->visible(fn ($record) => !empty($record->ploi_deployment_error)),
                                            ]),
                                    ]),

                                Forms\Components\Section::make('Minecraft Configuration')
                                    ->description('Server and plugin connection details')
                                    ->icon('heroicon-m-cube')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('minecraft_server_host')
                                                    ->label('Server Host')
                                                    ->placeholder('play.openminetopia.nl'),
                                                Forms\Components\TextInput::make('minecraft_plugin_ip')
                                                    ->label('Plugin API Address')
                                                    ->placeholder('127.0.0.1:25570'),
                                            ]),
                                    ]),
                            ]),

                        // Status & Info (Right Column - 1 span)
                        Forms\Components\Group::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\Section::make('Status Information')
                                    ->description('Current instance status')
                                    ->icon('heroicon-m-information-circle')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_paid')
                                            ->label('Payment Received')
                                            ->disabled(),
                                        Forms\Components\Toggle::make('dns_verified')
                                            ->label('DNS Verified')
                                            ->disabled(),
                                        Forms\Components\Toggle::make('has_set_api_tokens')
                                            ->label('API Tokens Configured')
                                            ->disabled(),
                                        Forms\Components\Toggle::make('ploi_ssl_enabled')
                                            ->label('SSL Enabled')
                                            ->disabled(),
                                    ]),

                                Forms\Components\Section::make('Ploi Configuration')
                                    ->description('Ploi server details')
                                    ->icon('heroicon-m-server-stack')
                                    ->schema([
                                        Forms\Components\TextInput::make('ploi_server_id')
                                            ->label('Server ID')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('ploi_site_id')
                                            ->label('Site ID')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('ploi_database_name')
                                            ->label('Database Name')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('ploi_database_user')
                                            ->label('Database User')
                                            ->disabled(),
                                    ]),

                                Forms\Components\Section::make('API Tokens')
                                    ->description('Authentication tokens')
                                    ->icon('heroicon-m-key')
                                    ->schema([
                                        Forms\Components\TextInput::make('plugin_api_token')
                                            ->label('Plugin API Token')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('instance_api_token')
                                            ->label('Instance API Token')
                                            ->disabled(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hostname')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'removed',
                        'warning' => 'pending',
                        'success' => 'active',
                        'gray' => 'suspended',
                    ]),
                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean()
                    ->label('Paid'),
                Tables\Columns\IconColumn::make('dns_verified')
                    ->boolean()
                    ->label('DNS'),
                Tables\Columns\TextColumn::make('version'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                        'removed' => 'Removed',
                    ]),
                Tables\Filters\TernaryFilter::make('is_paid')
                    ->label('Payment Status'),
                Tables\Filters\TernaryFilter::make('dns_verified')
                    ->label('DNS Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            SubscriptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstances::route('/'),
            'create' => Pages\CreateInstance::route('/create'),
            'edit' => Pages\EditInstance::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }
}
