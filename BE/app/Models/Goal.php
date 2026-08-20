<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $table = 'goals';

    protected $fillable = [
        'text',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
