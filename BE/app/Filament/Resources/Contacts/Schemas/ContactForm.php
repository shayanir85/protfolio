<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('نام')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('شماره تماس')
                    ->tel()
                    ->required()
                    ->maxLength(50),
                Textarea::make('message')
                    ->label('پیام')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
