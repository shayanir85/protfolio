<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    protected $table = 'theme_settings';

    protected $fillable = [
        'primary_color',
        'secondary_color',
        'accent_color',
        'gradient_start',
        'gradient_end',
        'gradient_angle',
        'dark_primary_color',
        'dark_secondary_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
