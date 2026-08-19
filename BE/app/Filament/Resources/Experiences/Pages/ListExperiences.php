<?php

namespace App\Filament\Resources\Experiences\Pages;

use App\Filament\Resources\Experiences\ExperiencesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExperiences extends ListRecords
{
    protected static string $resource = ExperiencesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
