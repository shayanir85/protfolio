<?php

namespace App\Filament\Resources\Goals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GoalTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icon')
                    ->label('آیکون')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('text')
                    ->label('متن هدف')
                    ->searchable()
                    ->limit(80)
                    ->wrap(),

                TextColumn::make('sort_order')
                    ->label('ترتیب')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('آخرین به‌روزرسانی')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
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
