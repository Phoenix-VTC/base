<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'published' => 'boolean',
        'featured' => 'boolean',
        'external_event' => 'boolean',
        'public_event' => 'boolean',
    ];

    public static function getFeaturedEvents()
    {
        return self::where('published', true)->where('featured', true)->get();
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hosted_by');
    }

    // TODO: Find a better way to do this. Perhaps integrate it with the Game model.
    public function getDistanceMetricAttribute(): string
    {
        if ($this->game_id === 1) {
            $unit = 'kilometres';
        }

        if ($this->game_id === 2) {
            $unit = 'miles';
        }

        return "$this->distance $unit";
    }
}
