<?php

namespace App\Filament\Resources\HeroSection\Pages;

use App\Filament\Resources\HeroSection\HeroSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeroSection extends EditRecord
{
    protected static string $resource = HeroSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
