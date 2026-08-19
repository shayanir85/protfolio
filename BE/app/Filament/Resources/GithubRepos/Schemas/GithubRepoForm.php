<?php

namespace App\Filament\Resources\GithubRepos\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Toggle;

class GithubRepoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->label('نام مخزن')
                    ->required()
                    ->maxLength(255),
                TextInput::make('html_url')
                    ->label('آدرس مخزن')
                    ->required()
                    ->url()
                    ->maxLength(255),
                MarkdownEditor::make('description')
                    ->label('توضیحات')
                    ->columnSpanFull(),
                TextInput::make('ssh_url')
                    ->label('آدرس SSH')
                    ->required()
                    ->maxLength(255),
                TextInput::make('stargazers_count')
                    ->label('تعداد ستاره‌ها')
                    ->numeric()
                    ->required(),
                TextInput::make('watchers_count')
                    ->label('تعداد تماشاگران')
                    ->numeric()
                    ->required(),
                TextInput::make('forks_count')
                    ->label('تعداد فورک‌ها')
                    ->numeric()
                    ->required(),
                TextInput::make('pushed_at')
                    ->label('آخرین بروزرسانی')
                    ->required(),
                Toggle::make('show')
                    ->label('نمایش در پورتفولیو')
                    ->required(),
            ]);
    }
}
