<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PloiSettingsResource\Pages;
use App\Models\PloiSettings;
use App\Services\PloiService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class PloiSettingsResource extends Resource
{
    protected static ?string $model = PloiSettings::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Ploi Configuration';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $settings = PloiSettings::first();
        $servers = [];

        if ($settings && $settings->api_token) {
            try {
                $ploiService = new PloiService();
                $servers = collect($ploiService->getServers())->pluck('name', 'id')->toArray();
            } catch (\Exception $e) {
                Notification::make()
                    ->warning()
                    ->title('Could not fetch servers')
                    ->body('Please ensure your API token is valid.')
                    ->send();
            }
        }

        return $form
            ->schema([
                Forms\Components\Section::make('Ploi Configuration')
                    ->schema([
                        Forms\Components\TextInput::make('api_token')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn ($record) => !$record)
                            ->helperText('Leave empty to keep the existing token.'),
                        Forms\Components\Select::make('default_server_id')
                            ->label('Default Server')
                            ->options($servers)
                            ->required()
                            ->visible(fn () => !empty($servers))
                            ->helperText(empty($servers) ? 'Save your API token first to load available servers.' : ''),
                        Forms\Components\TextInput::make('repository_url')
                            ->label('Repository URL')
                            ->required()
                            ->default('https://github.com/OpenMinetopia/portal.git'),
                        Forms\Components\TextInput::make('repository_branch')
                            ->label('Repository Branch')
                            ->required()
                            ->default('main'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('default_server_id')
                    ->label('Default Server ID'),
                Tables\Columns\TextColumn::make('repository_url')
                    ->label('Repository URL'),
                Tables\Columns\TextColumn::make('repository_branch')
                    ->label('Branch'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePloiSettings::route('/'),
        ];
    }
} 