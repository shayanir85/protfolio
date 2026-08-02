<?php

namespace App\Filament\Resources\GithubRepos\Pages;

use App\Filament\Resources\GithubRepos\GithubRepoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGithubRepo extends EditRecord
{
    protected static string $resource = GithubRepoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
