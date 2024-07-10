<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WatchedVideo extends Model
{
    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
