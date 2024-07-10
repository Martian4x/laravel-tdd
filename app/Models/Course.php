<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public $casts = [
        'learnings' => 'array',
        'released_at' => 'datetime'
    ];

    public function scopeReleased(Builder $builder): Builder
    {
        return $builder->whereNotNull('released_at');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

}
