<?php

namespace App\Filament\Resources;

use App\Models\EavEntity;
use BackedEnum;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class EavEntityResource extends Resource
{
    protected static ?string $model = EavEntity::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationLabel = 'Content Entities';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->required()
                    ->options([
                        'about_blurb' => 'About Blurb',
                        'profile_image' => 'Profile Image',
                        'skill_set' => 'Skill Set',
                        'experience_item' => 'Experience Item',
                        'pricing_tier' => 'Pricing Tier',
                        'contact_info' => 'Contact Info',
                    ]),
                KeyValue::make('data')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('type')->badge()->sortable(),
                TextColumn::make('data')
                    ->limit(60)
                    ->formatStateUsing(fn ($state) => json_encode($state)),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'about_blurb' => 'About Blurb',
                        'profile_image' => 'Profile Image',
                        'skill_set' => 'Skill Set',
                        'experience_item' => 'Experience Item',
                        'pricing_tier' => 'Pricing Tier',
                        'contact_info' => 'Contact Info',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\EavEntityResource\Pages\ListEavEntities::route('/'),
            'create' => \App\Filament\Resources\EavEntityResource\Pages\CreateEavEntity::route('/create'),
            'edit' => \App\Filament\Resources\EavEntityResource\Pages\EditEavEntity::route('/{record}/edit'),
        ];
    }
}
