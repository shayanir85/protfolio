<?php

namespace App\Filament\Resources\Experiences\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('position')
                    ->label('موقعیت شغلی')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('explanation')
                    ->label('توضیحات')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->label('تاریخ شروع')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('تاریخ پایان')
                    ->date()
                    ->placeholder('شغل فعلی')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
