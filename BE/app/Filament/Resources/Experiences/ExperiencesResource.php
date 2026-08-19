<?php

namespace App\Filament\Resources\Experiences;

use App\Filament\Resources\Experiences\Pages\CreateExperiences;
use App\Filament\Resources\Experiences\Pages\EditExperiences;
use App\Filament\Resources\Experiences\Pages\ListExperiences;
use App\Filament\Resources\Experiences\Schemas\ExperiencesForm;
use App\Filament\Resources\Experiences\Tables\ExperiencesTable;
use App\Models\Experience;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExperiencesResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $modelLabel = 'تجربه کاری';

    protected static ?string $pluralModelLabel = 'تجربیات کاری';

    protected static ?string $navigationLabel = 'تجربیات کاری';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ExperiencesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExperiencesTable::configure($table);
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
            'index' => ListExperiences::route('/'),
            'create' => CreateExperiences::route('/create'),
            'edit' => EditExperiences::route('/{record}/edit'),
        ];
    }
}
