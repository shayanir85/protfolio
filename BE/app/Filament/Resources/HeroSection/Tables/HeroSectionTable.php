<?php

namespace App\Filament\Resources\HeroSection\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HeroSectionTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('greeting')
                    ->label('پیش‌عنوان')
                    ->searchable()
                    ->sortable()
                    ->default('-'),

                TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('badge_text')
                    ->label('بج وضعیت کاری')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('availability_status')
                    ->label('وضعیت شغلی')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'open_to_work' => 'info',
                        'busy' => 'warning',
                        'unavailable' => 'gray',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'آماده به کار',
                        'open_to_work' => 'پذیرای پیشنهاد',
                        'busy' => 'مشغول پروژه',
                        'unavailable' => 'عدم دسترسی',
                        default => $state,
                    }),

                IconColumn::make('enable_typewriter')
                    ->label('ماشین تحریر')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('فعال')
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
