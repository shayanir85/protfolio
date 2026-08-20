<?php

namespace App\Filament\Resources\AboutMe\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutMeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('اطلاعات بخش درباره من')
                    ->description('تنظیم عنوان، زیرعنوان و آواتار')
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان بخش')
                            ->placeholder('درباره من')
                            ->maxLength(255),
                        TextInput::make('subtitle')
                            ->label('زیرعنوان')
                            ->placeholder('بیشتر بشناسید')
                            ->maxLength(255),
                        FileUpload::make('avatar')
                            ->label('تصویر آواتار')
                            ->image()
                            ->directory('avatars')
                            ->imageEditor()
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('فعال / نمایش در وب‌سایت')
                            ->default(true)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('محتوای متنی HTML (Text Editor)')
                    ->description('متن و بخش‌های مربوط به درباره من را با استفاده از ویرایشگر زیر ایجاد کنید.')
                    ->schema([
                        RichEditor::make('content')
                            ->label('محتوای درباره من')
                            ->placeholder('توضیحات، مهارت‌ها و اهداف خود را اینجا بنویسید...')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
