<?php

namespace App\Filament\Resources\ThemeSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThemeSettingTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('primary_color')
                    ->label('رنگ اصلی')
                    ->copyable(),

                ColorColumn::make('secondary_color')
                    ->label('رنگ ثانویه')
                    ->copyable(),

                ColorColumn::make('accent_color')
                    ->label('رنگ تاکیدی')
                    ->copyable(),

                ColorColumn::make('gradient_start')
                    ->label('شروع گرادیانت'),

                ColorColumn::make('gradient_end')
                    ->label('پایان گرادیانت'),

                TextColumn::make('gradient_angle')
                    ->label('زاویه'),

                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),

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
