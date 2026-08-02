<?php

namespace App\Filament\Resources\GithubRepos\Pages;

use App\Filament\Resources\GithubRepos\GithubRepoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGithubRepos extends ListRecords
{
    protected static string $resource = GithubRepoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
