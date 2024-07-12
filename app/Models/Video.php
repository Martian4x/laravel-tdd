<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;

    public function getReadableDuration(): string
    {
        return Str::of($this->duration_mn)->append('min');
    }

    public function Course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function alreadyWatchedByCurrentUser(): bool
    {
        return (bool) auth()->user()->videos()->where('video_id', $this->id)->count();
    }
}

