<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLinks extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Explicitly set because the migration uses PascalCase 'SocialLinks'
     * instead of the Laravel convention 'social_links'.
     */
    protected $table = 'SocialLinks';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'social_link',
        'social_media_name',
    ];

    /**
     * Get the user that owns this social link.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}