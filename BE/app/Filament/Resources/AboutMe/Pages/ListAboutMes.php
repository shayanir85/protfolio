<?php

namespace App\Filament\Resources\AboutMe\Pages;

use App\Filament\Resources\AboutMe\AboutMeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAboutMes extends ListRecords
{
    protected static string $resource = AboutMeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
