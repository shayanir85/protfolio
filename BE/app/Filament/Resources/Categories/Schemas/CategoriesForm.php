<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('نام دسته‌بندی')
                    ->required(),
                Select::make('user_id')
                    ->label('کاربر')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }
}
