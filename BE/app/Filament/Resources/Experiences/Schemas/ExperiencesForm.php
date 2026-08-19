<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExperiencesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('عنوان')
                    ->required()
                    ->maxLength(255),
                TextInput::make('position')
                    ->label('موقعیت شغلی')
                    ->required()
                    ->maxLength(255),
                Textarea::make('explanation')
                    ->label('توضیحات')
                    ->rows(4)
                    ->nullable()
                    ->columnSpanFull(),
                DatePicker::make('start_date')
                    ->label('تاریخ شروع')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('تاریخ پایان')
                    ->nullable(),
            ]);
    }
}
