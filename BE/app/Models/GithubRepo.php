<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


#[Fillable(['full_name', 'html_url', 'description', 'ssh_url', 'stargazers_count', 'watchers_count', 'forks_count', 'pushed_at', 'show'])]
class GithubRepo extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pushed_at' => 'datetime',
            'stargazers_count' => 'integer',
            'watchers_count' => 'integer',
            'forks_count' => 'integer',
            'show' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // <-- Correct relation syntax
    }
}
