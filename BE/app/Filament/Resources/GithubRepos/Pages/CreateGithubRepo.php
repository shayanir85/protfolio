<?php

namespace App\Filament\Resources\GithubRepos\Pages;

use App\Filament\Resources\GithubRepos\GithubRepoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGithubRepo extends CreateRecord
{
    protected static string $resource = GithubRepoResource::class;
}
