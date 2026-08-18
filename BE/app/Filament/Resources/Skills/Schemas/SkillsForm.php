<?php

namespace App\Filament\Resources\Skills\Schemas;

use App\Enums\SkillLevel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SkillsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                FileUpload::make('iconUrl')
                    ->label('Skill Icon')
                    ->disk('public')
                    ->directory('icons')
                    ->visibility('public')
                    ->image()
                    ->nullable(),
                Select::make('level')
                    ->options(SkillLevel::class)
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
            ]);
    }
}
