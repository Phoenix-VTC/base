<?php

namespace App\Models;

use GrahamCampbell\Markdown\Facades\Markdown;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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

    public function attendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class);
    }

    // TODO: Find a better way to do this. Perhaps integrate it with the Game model.
    public function getDistanceMetricAttribute(): string
    {
        $unit = 'unknown';

        if ($this->game_id === 1) {
            $unit = 'kilometres';
        }

        if ($this->game_id === 2) {
            $unit = 'miles';
        }

        return "$this->distance $unit";
    }

    public function getTMPDescriptionAttribute($value): string
    {
        return Markdown::convertToHtml($this->truckersmp_event_data['response']['description'] ?? '');
    }

    public function getTruckersMPEventDataAttribute()
    {
        if ($this->tmp_event_id) {
            return Cache::remember($this->tmp_event_id . "_tmp_event_data", 86400, function () {
                $client = new Client();

                $response = $client->get('https://api.truckersmp.com/v2/events/' . $this->tmp_event_id)->getBody();
                $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

                return collect($response);
            });
        }

        return null;
    }

    public function getTruckersMPEventVTCDataAttribute()
    {
        if (isset($this->truckersmp_event_data['response']['vtc']['name'])) {
            return Cache::remember($this->truckersmp_event_data['response']['vtc']['id'] . "_tmp_event_vtc_data", 86400, function () {
                $client = new Client();

                $response = $client->get('https://api.truckersmp.com/v2/vtc/' . $this->truckersmp_event_data['response']['vtc']['id'])->getBody();
                $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

                return collect($response);
            });
        }

        return null;
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->name);
    }

    public function game(bool $abbreviation = true): string
    {
        if (!$abbreviation) {
            return Game::getQualifiedName($this->game_id);
        }

        return Game::getAbbreviationById($this->game_id);
    }

    public function getIsHighRewardingAttribute(): bool
    {
        return ($this->points >= 400);
    }
}
