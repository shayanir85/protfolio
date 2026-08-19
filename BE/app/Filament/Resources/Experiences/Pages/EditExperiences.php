<?php

namespace App\Filament\Resources\Experiences\Pages;

use App\Filament\Resources\Experiences\ExperiencesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExperiences extends EditRecord
{
    protected static string $resource = ExperiencesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
