<?php

namespace App\Filament\Resources\AboutMe\Pages;

use App\Filament\Resources\AboutMe\AboutMeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAboutMe extends EditRecord
{
    protected static string $resource = AboutMeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
