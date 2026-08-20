<?php

namespace App\Filament\Resources\AboutMe\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutMeTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('آواتار')
                    ->circular(),
                TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                TextColumn::make('subtitle')
                    ->label('زیرعنوان')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('content')
                    ->label('پیش‌نمایش متن')
                    ->html()
                    ->limit(60)
                    ->placeholder('ثبت نشده'),
                IconColumn::make('is_active')
                    ->label('وضعیت نمایش')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('آخرین به‌روزرسانی')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
