<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('نام'),
                TextEntry::make('phone')
                    ->label('شماره تماس'),
                TextEntry::make('message')
                    ->label('پیام')
                    ->prose()
                    ->listWithLineBreaks(),
            ]);
    }
}
