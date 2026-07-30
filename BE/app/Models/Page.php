<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Casts;

#[Fillable(['slug', 'layout'])]
class Page extends Model
{
    protected function casts(): array
    {
        return [
            'layout' => 'array',
        ];
    }
}
