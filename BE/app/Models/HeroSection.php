<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $table = 'hero_sections';

    protected $fillable = [
        'badge_text',
        'greeting',
        'name',
        'title',
        'description',
        'show_availability',
        'availability_status',
        'availability_pulse',
        'enable_typewriter',
        'typewriter_prefix',
        'typewriter_strings',
        'typewriter_speed',
        'typewriter_delete_speed',
        'typewriter_delay',
        'buttons',
        'stats',
        'scroll_indicator_text',
        'show_scroll_indicator',
        'is_active',
    ];

    protected $casts = [
        'show_availability' => 'boolean',
        'availability_pulse' => 'boolean',
        'enable_typewriter' => 'boolean',
        'show_scroll_indicator' => 'boolean',
        'is_active' => 'boolean',
        'typewriter_strings' => 'array',
        'buttons' => 'array',
        'stats' => 'array',
        'typewriter_speed' => 'integer',
        'typewriter_delete_speed' => 'integer',
        'typewriter_delay' => 'integer',
    ];
}
