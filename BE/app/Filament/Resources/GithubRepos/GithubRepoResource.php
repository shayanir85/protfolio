<?php

namespace App\Filament\Resources\GithubRepos;

use App\Filament\Resources\GithubRepos\Pages\CreateGithubRepo;
use App\Filament\Resources\GithubRepos\Pages\EditGithubRepo;
use App\Filament\Resources\GithubRepos\Pages\ListGithubRepos;
use App\Filament\Resources\GithubRepos\Schemas\GithubRepoForm;
use App\Filament\Resources\GithubRepos\Tables\GithubReposTable;
use App\Models\GithubRepo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GithubRepoResource extends Resource
{
    protected static ?string $model = GithubRepo::class;

    protected static ?string $modelLabel = 'مخزن گیت‌هاب';

    protected static ?string $pluralModelLabel = 'مخازن گیت‌هاب';

    protected static ?string $navigationLabel = 'مخازن گیت‌هاب';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCodeBracketSquare;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Schema $schema): Schema
    {
        return GithubRepoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GithubReposTable::configure($table);
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
            'index' => ListGithubRepos::route('/'),
            'create' => CreateGithubRepo::route('/create'),
            'edit' => EditGithubRepo::route('/{record}/edit'),
        ];
    }
}
