<?php

namespace App\Filament\Resources\ThemeSettings\Pages;

use App\Filament\Resources\ThemeSettings\ThemeSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditThemeSetting extends EditRecord
{
    protected static string $resource = ThemeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
