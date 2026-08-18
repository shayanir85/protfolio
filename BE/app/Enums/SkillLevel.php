<?php

namespace App\Enums;

enum SkillLevel: string
{
    case familiar = 'familiar';
    case beginner = 'beginner';
    case intermediate = 'intermediate';
    case midLevel = 'mid-level';
    case expert = 'expert';

    public function getLabel(): string
    {
        return match ($this) {
            self::familiar => 'familiar',
            self::beginner => 'beginner',
            self::intermediate => 'intermediate',
            self::midLevel => 'mid-level',
            self::expert => 'expert',
        };
    }
}