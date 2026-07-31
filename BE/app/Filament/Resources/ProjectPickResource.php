<?php

namespace App\Filament\Resources;

use App\Models\ProjectPick;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectPickResource extends Resource
{
    protected static ?string $model = ProjectPick::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-code-bracket';

    protected static ?string $navigationLabel = 'Project Picks';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('repo_name')
                    ->required()
                    ->label('Repository (e.g. laravel/laravel)'),
                TextInput::make('display_order')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('display_order')
            ->defaultSort('display_order')
            ->columns([
                TextColumn::make('repo_name')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('display_order')
                    ->sortable(),
                TextColumn::make('created_at')->dateTime(),
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
            'index' => \App\Filament\Resources\ProjectPickResource\Pages\ListProjectPicks::route('/'),
            'create' => \App\Filament\Resources\ProjectPickResource\Pages\CreateProjectPick::route('/create'),
            'edit' => \App\Filament\Resources\ProjectPickResource\Pages\EditProjectPick::route('/{record}/edit'),
        ];
    }
};
