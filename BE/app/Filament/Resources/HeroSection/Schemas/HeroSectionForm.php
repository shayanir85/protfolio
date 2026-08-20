<?php

namespace App\Filament\Resources\HeroSection\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeroSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('عناوین و اطلاعات اصلی (Hero Titles & Bio)')
                    ->description('تنظیم عنوان خوش‌آمدگویی، نام، عنوان اصلی و بیوگرافی')
                    ->schema([
                        TextInput::make('greeting')
                            ->label('پیش‌عنوان / سلام')
                            ->placeholder('سلام من / Hi, I\'m')
                            ->maxLength(255),

                        TextInput::make('name')
                            ->label('نام و نام خانوادگی (با افکت گرادیانت)')
                            ->placeholder('شایان / Shayan')
                            ->maxLength(255),

                        TextInput::make('title')
                            ->label('عنوان اصلی صفحه (اختیاری)')
                            ->placeholder('توسعه‌دهنده نرم‌افزار / Software Engineer')
                            ->maxLength(255),

                        RichEditor::make('description')
                            ->label('متن توضیحات / بیو')
                            ->placeholder('توضیحات معرفی، اشتیاق و اهداف خود را بنویسید...')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'link',
                                'codeBlock',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('فعال / نمایش در وب‌سایت')
                            ->default(true)
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('وضعیت شغلی و در دسترس بودن (Job Availability Status)')
                    ->description('نمایش یا عدم نمایش بج وضعیت شغلی با پالس نوری زنده')
                    ->schema([
                        Toggle::make('show_availability')
                            ->label('نمایش بج وضعیت شغلی (Job Status Badge)')
                            ->default(true),

                        TextInput::make('badge_text')
                            ->label('متن بج وضعیت')
                            ->placeholder('آماده همکاری و استخدام / Available for opportunities')
                            ->maxLength(255),

                        Select::make('availability_status')
                            ->label('نوع وضعیت کاری')
                            ->options([
                                'available' => 'آماده به کار (سبز / Available)',
                                'open_to_work' => 'پذیرای پیشنهادات (آبی / Open to offers)',
                                'busy' => 'مشغول پروژه (نارنجی / Busy)',
                                'unavailable' => 'عدم دسترسی (خاکستری / Unavailable)',
                            ])
                            ->default('available'),

                        Toggle::make('availability_pulse')
                            ->label('افکت پالس نوری متحرک (Pulse Animation)')
                            ->default(true),
                    ])->columns(2),

                Section::make('سازنده افکت ماشین تحریر (Typewriter Effect Builder)')
                    ->description('تنظیمات افکت تایپ متن متحرک، کلمات و سرعت تایپ')
                    ->schema([
                        Toggle::make('enable_typewriter')
                            ->label('فعال بودن افکت ماشین تحریر')
                            ->default(true)
                            ->columnSpanFull(),

                        TextInput::make('typewriter_prefix')
                            ->label('پیشوند متن تایپ شونده')
                            ->placeholder('یک / I\'m a ')
                            ->maxLength(255),

                        TagsInput::make('typewriter_strings')
                            ->label('عبارت‌های متحرک تایپ شونده')
                            ->placeholder('افزودن عبارت جدید و اینتر')
                            ->columnSpanFull(),

                        TextInput::make('typewriter_speed')
                            ->label('سرعت تایپ (میلی‌ثانیه)')
                            ->numeric()
                            ->default(80),

                        TextInput::make('typewriter_delete_speed')
                            ->label('سرعت پاک کردن (میلی‌ثانیه)')
                            ->numeric()
                            ->default(40),

                        TextInput::make('typewriter_delay')
                            ->label('توقف بین هر کلمه (میلی‌ثانیه)')
                            ->numeric()
                            ->default(2000),
                    ])->columns(3),

                Section::make('سازنده دکمه‌های کنش (Action Buttons Builder)')
                    ->description('افزودن، ویرایش، ترتیب‌بندی و استایل‌دهی دکمه‌های هیرو')
                    ->schema([
                        Repeater::make('buttons')
                            ->label('دکمه‌های هیرو سکشن')
                            ->schema([
                                TextInput::make('label')
                                    ->label('عنوان دکمه')
                                    ->required(),

                                Select::make('action_type')
                                    ->label('نوع عملکرد')
                                    ->options([
                                        'scroll' => 'اسکرول به بخش داخلی صفحه (Scroll to section)',
                                        'link' => 'لینک خارجی / آدرس وب (URL)',
                                        'email' => 'ارسال ایمیل (mailto:)',
                                    ])
                                    ->default('scroll')
                                    ->required(),

                                TextInput::make('target')
                                    ->label('مقصد (شناسه بخش، آدرس URL یا ایمیل)')
                                    ->placeholder('مثال: projects, contact, https://github.com')
                                    ->required(),

                                Select::make('variant')
                                    ->label('استایل دکمه')
                                    ->options([
                                        'primary_gradient' => 'گرادیانت اصلی پررنگ (Primary Gradient)',
                                        'outline' => 'دورخطی (Outline)',
                                        'flat' => 'تخت بدون حاشیه (Flat)',
                                        'secondary' => 'ثانویه (Secondary)',
                                        'glass' => 'شیشه‌ای مدرن (Glassmorphism)',
                                    ])
                                    ->default('primary_gradient'),

                                TextInput::make('icon')
                                    ->label('آیکون سمت چپ (Material Icon)')
                                    ->placeholder('mail, work, download'),

                                TextInput::make('icon_right')
                                    ->label('آیکون سمت راست (Material Icon)')
                                    ->placeholder('arrow_forward, open_in_new'),

                                Select::make('size')
                                    ->label('اندازه')
                                    ->options([
                                        'sm' => 'کوچک',
                                        'md' => 'متوسط',
                                        'lg' => 'بزرگ',
                                    ])
                                    ->default('lg'),

                                Toggle::make('new_tab')
                                    ->label('باز شدن در تب جدید (برای لینک‌ها)')
                                    ->default(false),
                            ])
                            ->columns(4)
                            ->collapsible()
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),

                Section::make('کارت‌های آمار و ارقام (Stats Counters Builder)')
                    ->description('شمارنده‌های عددی زیر دکمه‌ها با انیمیشن شمارش')
                    ->schema([
                        Repeater::make('stats')
                            ->label('کارت‌های آمار')
                            ->schema([
                                TextInput::make('label')
                                    ->label('عنوان آمار')
                                    ->required(),

                                TextInput::make('value')
                                    ->label('مقدار عددی')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('suffix')
                                    ->label('پسوند (مثل + یا %)')
                                    ->placeholder('+'),
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),

                Section::make('تنظیمات نشانگر اسکرول (Scroll Indicator)')
                    ->description('آیکون موس و متن انتهای هیرو سکشن')
                    ->schema([
                        Toggle::make('show_scroll_indicator')
                            ->label('نمایش نشانگر اسکرول به پایین')
                            ->default(true),

                        TextInput::make('scroll_indicator_text')
                            ->label('متن نشانگر اسکرول')
                            ->placeholder('اسکرول کنید / Scroll to explore')
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }
}
