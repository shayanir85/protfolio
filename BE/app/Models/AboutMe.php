<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutMe extends Model
{
    protected $table = 'about_mes';

    protected $fillable = [
        'title',
        'subtitle',
        'avatar',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'avatar_url',
    ];

    /**
     * Get the avatar URL attribute.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar) {
            return null;
        }

        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        $path = ltrim($this->avatar, '/');
        if (!str_starts_with($path, 'storage/')) {
            $path = 'storage/' . $path;
        }

        if (request()) {
            return rtrim(request()->getSchemeAndHttpHost(), '/') . '/' . $path;
        }

        return asset($path);
    }
}
