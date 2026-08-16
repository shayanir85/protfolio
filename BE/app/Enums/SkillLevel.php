<?php

namespace App\Enums;

enum SkillLevel: string
{
    case familiar = 'familiar';
    case beginner = 'beginner';
    case intermediate = 'intermediate';
    case midLevel = 'midLevel';
    case expert = 'expert';

    public function getLabel(): string
    {
        return match ($this) {
            self::familiar => 'familiar',
            self::beginner => 'beginner',
            self::intermediate => 'intermediate',
            self::midLevel => 'midLevel',
            self::expert => 'expert',
        };
    }
}