<?php

namespace App\Filament\Resources\HeroSection\Pages;

use App\Filament\Resources\HeroSection\HeroSectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeroSections extends ListRecords
{
    protected static string $resource = HeroSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
