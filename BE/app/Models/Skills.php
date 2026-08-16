<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Categories;

class Skills extends Model
{
    protected $table = 'skills';
    
    protected $fillable = [
        'name',
        'level',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id'); 
    }
}
