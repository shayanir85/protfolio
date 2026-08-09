<?php

namespace App\Filament\Resources\GithubRepos\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class GithubRepoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('html_url')
                    ->required()
                    ->url()
                    ->maxLength(255),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                TextInput::make('ssh_url')
                    ->required()
                    ->maxLength(255),
                TextInput::make('stargazers_count')
                    ->numeric()
                    ->required(),
                TextInput::make('watchers_count')
                    ->numeric()
                    ->required(),
                TextInput::make('forks_count')
                    ->numeric()
                    ->required(),
                TextInput::make('pushed_at')
                    ->required(),
                Toggle::make('show')
                    ->required(),
            ]);
    }
}
