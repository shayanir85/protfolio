<?php

namespace App\Filament\Resources\ThemeSettings\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ThemeSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('رنگ‌های اصلی پورتفولیو (Primary & Secondary Colors)')
                    ->description('تنظیم رنگ‌های شاخص، دکمه‌ها، آیکون‌ها و المان‌های تعاملی')
                    ->schema([
                        ColorPicker::make('primary_color')
                            ->label('رنگ اصلی (Primary Color)')
                            ->default('#667eea')
                            ->required(),

                        ColorPicker::make('secondary_color')
                            ->label('رنگ ثانویه (Secondary Color)')
                            ->default('#764ba2')
                            ->required(),

                        ColorPicker::make('accent_color')
                            ->label('رنگ تاکیدی / استاتیک (Accent Color)')
                            ->default('#06b6d4')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('فعال / اعمال این قالب رنگی بر وب‌سایت')
                            ->default(true)
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('تنظیمات گرادیانت پویا (Dynamic Gradient Settings)')
                    ->description('تعیین رنگ شروع، پایان و زاویه گرادیانت پس‌زمینه و تیترها')
                    ->schema([
                        ColorPicker::make('gradient_start')
                            ->label('رنگ شروع گرادیانت (Gradient Start)')
                            ->default('#667eea')
                            ->required(),

                        ColorPicker::make('gradient_end')
                            ->label('رنگ پایان گرادیانت (Gradient End)')
                            ->default('#764ba2')
                            ->required(),

                        Select::make('gradient_angle')
                            ->label('زاویه گرادیانت')
                            ->options([
                                '135deg' => '۱۳۵ درجه (مورب استاندارد - 135deg)',
                                '90deg' => '۹۰ درجه (افقی چپ به راست - 90deg)',
                                '180deg' => '۱۸۰ درجه (عمودی بالا به پایین - 180deg)',
                                '45deg' => '۴۵ درجه (مورب معکوس - 45deg)',
                                'to right' => 'به سمت راست (To Right)',
                            ])
                            ->default('135deg')
                            ->required(),
                    ])->columns(3),

                Section::make('رنگ‌های حالت تاریک (Dark Mode Accents - اختیاری)')
                    ->description('شخصی‌سازی رنگ‌های شاخص در حالت تاریک')
                    ->schema([
                        ColorPicker::make('dark_primary_color')
                            ->label('رنگ اصلی حالت تاریک')
                            ->default('#818cf8'),

                        ColorPicker::make('dark_secondary_color')
                            ->label('رنگ ثانویه حالت تاریک')
                            ->default('#a78bfa'),
                    ])->columns(2),
            ]);
    }
}
