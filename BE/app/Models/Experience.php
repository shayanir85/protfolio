<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experiences';

    protected $fillable = [
        'title',
        'position',
        'explanation',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $appends = [
        'period',
    ];

    public function getPeriodAttribute(): string
    {
        $start = $this->start_date ? $this->start_date->format('Y-m-d') : '';
        if ($this->end_date) {
            $end = $this->end_date->format('Y-m-d');
            return "{$start} -> {$end}";
        }
        return "{$start} -> current job";
    }
}
