<?php

namespace App\Filament\Resources\SocialLinks\Pages;

use App\Filament\Resources\SocialLinks\SocialLinksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSocialLinks extends ManageRecords
{
    protected static string $resource = SocialLinksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();

                    return $data;
                }),
        ];
    }
}
