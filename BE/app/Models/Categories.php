<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\skills;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'user_id'
    ]; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
    public function skills(): HasMany
    {
        return $this->hasMany(skills::class, 'category_id');
    }
}
