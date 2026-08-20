<?php

namespace App\Filament\Resources\Goals;

use App\Filament\Resources\Goals\Pages\CreateGoal;
use App\Filament\Resources\Goals\Pages\EditGoal;
use App\Filament\Resources\Goals\Pages\ListGoals;
use App\Filament\Resources\Goals\Schemas\GoalForm;
use App\Filament\Resources\Goals\Tables\GoalTable;
use App\Models\Goal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GoalResource extends Resource
{
    protected static ?string $model = Goal::class;

    protected static ?string $modelLabel = 'هدف';

    protected static ?string $pluralModelLabel = 'اهداف من';

    protected static ?string $navigationLabel = 'اهداف من';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;

    protected static ?string $recordTitleAttribute = 'text';

    public static function form(Schema $schema): Schema
    {
        return GoalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GoalTable::configure($table);
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
            'index' => ListGoals::route('/'),
            'create' => CreateGoal::route('/create'),
            'edit' => EditGoal::route('/{record}/edit'),
        ];
    }
}
