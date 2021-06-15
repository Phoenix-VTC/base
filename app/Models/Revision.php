<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Revision extends \Venturecraft\Revisionable\Revision
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
