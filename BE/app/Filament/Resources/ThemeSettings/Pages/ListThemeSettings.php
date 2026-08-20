<?php

namespace App\Filament\Resources\ThemeSettings\Pages;

use App\Filament\Resources\ThemeSettings\ThemeSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThemeSettings extends ListRecords
{
    protected static string $resource = ThemeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
