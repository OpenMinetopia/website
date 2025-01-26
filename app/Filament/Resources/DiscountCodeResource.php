<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountCodeResource\Pages;
use App\Models\DiscountCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DiscountCodeResource extends Resource
{
    protected static ?string $model = DiscountCode::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                        'free' => 'Free (100% off)',
                    ])
                    ->reactive(),
                Forms\Components\TextInput::make('value')
                    ->numeric()
                    ->required()
                    ->hidden(fn ($get) => $get('type') === 'free')
                    ->suffix(fn ($get) => $get('type') === 'percentage' ? '%' : '€')
                    ->rules([
                        fn ($get) => function ($attribute, $value, $fail) use ($get) {
                            if ($get('type') === 'percentage' && $value > 100) {
                                $fail('Percentage cannot be greater than 100');
                            }
                        },
                    ]),
                Forms\Components\TextInput::make('max_uses')
                    ->numeric()
                    ->nullable(),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->nullable(),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'warning',
                        'fixed' => 'info',
                        'free' => 'success',
                    }),
                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn ($record) => match ($record->type) {
                        'percentage' => $record->value . '%',
                        'fixed' => '€' . $record->value,
                        'free' => 'Free',
                    }),
                Tables\Columns\TextColumn::make('used_count')
                    ->label('Uses'),
                Tables\Columns\TextColumn::make('max_uses')
                    ->label('Max Uses'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\Filter::make('not_expired')
                    ->query(fn ($query) => $query->where('expires_at', '>', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscountCodes::route('/'),
            'create' => Pages\CreateDiscountCode::route('/create'),
            'edit' => Pages\EditDiscountCode::route('/{record}/edit'),
        ];
    }
} 