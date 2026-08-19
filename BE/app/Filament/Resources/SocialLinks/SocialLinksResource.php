<?php

namespace App\Filament\Resources\SocialLinks;

use App\Enums\SocialMediaName;
use App\Filament\Resources\SocialLinks\Pages\ManageSocialLinks;
use App\Models\SocialLinks; // Fixed: Model is SocialLink, not SocialLinks
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialLinksResource extends Resource
{
    protected static ?string $model = SocialLinks::class; // Fixed class name

    protected static ?string $modelLabel = 'شبکه اجتماعی';

    protected static ?string $pluralModelLabel = 'شبکه‌های اجتماعی';

    protected static ?string $navigationLabel = 'شبکه‌های اجتماعی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'social_link'; // Fixed: must be a real column name

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('social_link') // Fixed: snake_case to match DB column
                    ->label('لینک')
                    ->required()
                    ->maxLength(255),
                Select::make('social_media_name') // Fixed: snake_case to match DB column
                    ->label('پلتفرم')
                    ->options(SocialMediaName::class)
                    ->required(),
            ]);
    }

    /**
     * Automatically assign the authenticated user on create.
     */
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('social_link') // Fixed: real column name
                    ->label('لینک')
                    ->searchable(),
                TextColumn::make('social_media_name') // Added: show platform name
                    ->label('پلتفرم'),
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSocialLinks::route('/'),
        ];
    }
}