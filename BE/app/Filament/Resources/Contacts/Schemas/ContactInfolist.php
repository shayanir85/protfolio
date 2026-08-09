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
                    ->label('Name'),
                TextEntry::make('phone')
                    ->label('Phone'),
                TextEntry::make('message')
                    ->label('Message')
                    ->prose()
                    ->listWithLineBreaks(),
            ]);
    }
}
