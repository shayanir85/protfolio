<?php

namespace App\Filament\Resources\Goals\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('اطلاعات هدف (Goal Details)')
                    ->description('عنوان یا شرح هدف و آیکون مربوطه')
                    ->schema([
                        Textarea::make('text')
                            ->label('متن هدف')
                            ->placeholder('مثال: رسیدن به سطح توسعه‌دهنده بک‌اند لاراول')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('icon')
                            ->label('آیکون متریال (Material Icon)')
                            ->placeholder('emoji_events, rocket_launch, share, groups, code, flag')
                            ->default('emoji_events'),

                        TextInput::make('sort_order')
                            ->label('ترتیب نمایش')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('فعال / نمایش در وب‌سایت')
                            ->default(true),
                    ])->columns(3),
            ]);
    }
}
