<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['type', 'data'])]
class EavEntity extends Model
{
    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
