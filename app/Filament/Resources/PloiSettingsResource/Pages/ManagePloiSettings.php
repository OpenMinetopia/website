<?php

namespace App\Filament\Resources\PloiSettingsResource\Pages;

use App\Filament\Resources\PloiSettingsResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions;

class ManagePloiSettings extends ManageRecords
{
    protected static string $resource = PloiSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => !static::$resource::getModel()::exists()),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 