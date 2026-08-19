<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SkillLevel: string implements HasLabel
{
    case familiar = 'familiar';
    case beginner = 'beginner';
    case intermediate = 'intermediate';
    case midLevel = 'mid-level';
    case expert = 'expert';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::familiar => 'آشنا',
            self::beginner => 'مبتدی',
            self::intermediate => 'متوسط',
            self::midLevel => 'نیمه‌حرفه‌ای',
            self::expert => 'حرفه‌ای / متخصص',
        };
    }
}