<?php

namespace App\Models;

use App\Enums\SkillLevel;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skills extends Model
{
    protected $table = 'skills';
    
    protected $fillable = [
        'name',
        'level',
        'category_id',
        'iconUrl',
    ];

    protected $casts = [
        'level' => SkillLevel::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id'); 
    }
}
