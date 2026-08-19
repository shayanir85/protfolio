<?php

namespace App\Filament\Resources\Contacts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('شماره تماس')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('پیام')
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
