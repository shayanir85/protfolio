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
                    ->label('نام مهارت')
                    ->required(),
                FileUpload::make('iconUrl')
                    ->label('آیکون مهارت')
                    ->disk('public')
                    ->directory('icons')
                    ->visibility('public')
                    ->image()
                    ->nullable(),
                Select::make('level')
                    ->label('سطح تسلط')
                    ->options(SkillLevel::class)
                    ->required(),
                Select::make('category_id')
                    ->label('دسته‌بندی')
                    ->relationship('category', 'name')
                    ->required(),
            ]);
    }
}
