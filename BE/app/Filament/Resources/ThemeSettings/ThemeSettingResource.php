<?php

namespace App\Filament\Resources\ThemeSettings;

use App\Filament\Resources\ThemeSettings\Pages\CreateThemeSetting;
use App\Filament\Resources\ThemeSettings\Pages\EditThemeSetting;
use App\Filament\Resources\ThemeSettings\Pages\ListThemeSettings;
use App\Filament\Resources\ThemeSettings\Schemas\ThemeSettingForm;
use App\Filament\Resources\ThemeSettings\Tables\ThemeSettingTable;
use App\Models\ThemeSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ThemeSettingResource extends Resource
{
    protected static ?string $model = ThemeSetting::class;

    protected static ?string $modelLabel = 'رنگ‌بندی و قالب';

    protected static ?string $pluralModelLabel = 'رنگ‌بندی و قالب پورتفولیو';

    protected static ?string $navigationLabel = 'رنگ‌بندی پورتفولیو';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    protected static ?string $recordTitleAttribute = 'primary_color';

    public static function form(Schema $schema): Schema
    {
        return ThemeSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThemeSettingTable::configure($table);
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
            'index' => ListThemeSettings::route('/'),
            'create' => CreateThemeSetting::route('/create'),
            'edit' => EditThemeSetting::route('/{record}/edit'),
        ];
    }
}
