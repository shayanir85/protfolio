<?php

namespace App\Filament\Resources\HeroSection;

use App\Filament\Resources\HeroSection\Pages\CreateHeroSection;
use App\Filament\Resources\HeroSection\Pages\EditHeroSection;
use App\Filament\Resources\HeroSection\Pages\ListHeroSections;
use App\Filament\Resources\HeroSection\Schemas\HeroSectionForm;
use App\Filament\Resources\HeroSection\Tables\HeroSectionTable;
use App\Models\HeroSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static ?string $modelLabel = 'هیرو سکشن';

    protected static ?string $pluralModelLabel = 'سازنده هیرو سکشن';

    protected static ?string $navigationLabel = 'هیرو سکشن';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return HeroSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HeroSectionTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHeroSections::route('/'),
            'create' => CreateHeroSection::route('/create'),
            'edit' => EditHeroSection::route('/{record}/edit'),
        ];
    }
}
