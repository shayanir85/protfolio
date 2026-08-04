<?php

namespace App\Enums;

enum SocialMediaName: string
{
    case Facebook = 'facebook';
    case Instagram = 'instagram';
    case Twitter = 'twitter';
    case LinkedIn = 'linkedin';
    case YouTube = 'youtube';
    case TikTok = 'tiktok';
    case GitHub = 'github';
    case Website = 'website';

    public function getLabel(): string
    {
        return match ($this) {
            self::Facebook => 'Facebook',
            self::Instagram => 'Instagram',
            self::Twitter => 'Twitter / X',
            self::LinkedIn => 'LinkedIn',
            self::YouTube => 'YouTube',
            self::TikTok => 'TikTok',
            self::GitHub => 'GitHub',
            self::Website => 'Website',
        };
    }
}