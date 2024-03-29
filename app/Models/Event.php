<?php

namespace App\Models;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property int $hosted_by
 * @property string $featured_image_url
 * @property string|null $map_image_url
 * @property string $description
 * @property string|null $server
 * @property array|null $required_dlcs
 * @property string|null $departure_location
 * @property string|null $arrival_location
 * @property \Illuminate\Support\Carbon $start_date
 * @property int|null $distance
 * @property int $points
 * @property int|null $game_id
 * @property int|null $tmp_event_id
 * @property bool $published
 * @property bool $featured
 * @property bool $external_event
 * @property bool $public_event
 * @property int|null $created_by
 * @property bool $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventAttendee[] $attendees
 * @property-read int|null $attendees_count
 * @property-read \App\Models\User|null $creator
 * @property-read string $distance_metric
 * @property-read bool $is_high_rewarding
 * @property-read bool $is_past
 * @property-read string $slug
 * @property-read string $t_m_p_description
 * @property-read mixed $truckers_m_p_event_data
 * @property-read mixed $truckers_m_p_event_v_t_c_data
 * @property-read \App\Models\User $host
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @method static \Database\Factories\EventFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Query\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereArrivalLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDepartureLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereExternalEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereFeaturedImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereHostedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMapImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePublicEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRequiredDlcs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTmpEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Event withoutTrashed()
 * @mixin \Eloquent
 */
class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    use RevisionableTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
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
        'completed' => 'boolean',
        'required_dlcs' => 'array',
    ];

    public static function getFeaturedEvents()
    {
        return self::where('published', true)->where('featured', true)->get();
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hosted_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function revisionHistoryWithUser(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable')->with('user');
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

        return $unit;
    }

    public function getTMPDescriptionAttribute($value): string
    {
        return Markdown::convertToHtml($this->truckersmp_event_data['response']['description'] ?? '');
    }

    public function getTruckersMPEventDataAttribute()
    {
        if ($this->tmp_event_id) {
            return Cache::remember($this->tmp_event_id . "_tmp_event_data", 86400, function () {
                return Http::get("https://api.truckersmp.com/v2/events/$this->tmp_event_id")->collect();
            });
        }

        return null;
    }

    public function getTruckersMPEventVTCDataAttribute()
    {
        if (isset($this->truckersmp_event_data['response']['vtc']['name'])) {
            return Cache::remember($this->truckersmp_event_data['response']['vtc']['id'] . "_tmp_event_vtc_data", 86400, function () {
                return Http::get("https://api.truckersmp.com/v2/vtc/{$this->truckersmp_event_data['response']['vtc']['id']}")->collect();
            });
        }

        return null;
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->name);
    }

    public function game(bool $abbreviation = true): ?string
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

    public function getIsPastAttribute(): bool
    {
        return $this->start_date->isPast();
    }

    /**
     * Route notifications for the Discord Member Events channel.
     *
     * @return string
     */
    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.channels.member-events');
    }

    /**
     * Get the total amount of events attended.
     *
     * Cached for 24 hours.
     *
     * @return int
     */
    public static function getTotalEventsAttended(): int
    {
        return Cache::remember("total_events_attended", 86400, function () {
            return self::where('external_event', true)->count();
        });
    }

    /**
     * Get the total amount of events hosted.
     *
     * Cached for 24 hours.
     *
     * @return int
     */
    public static function getTotalEventsHosted(): int
    {
        return Cache::remember("total_events_hosted", 86400, function () {
            return self::where('external_event', false)->count();
        });
    }

    /**
     * Get the total distance driven in events, in kilometres.
     *
     * Cached for 24 hours.
     *
     * @return int
     */
    public static function getTotalEventsDistance(): int
    {
        return Cache::remember("total_event_distance", 86400, function () {
            $ets = self::where('game_id', 1)->sum('distance');
            $ats = self::where('game_id', 2)->sum('distance') * 1.60934;

            return $ets + $ats;
        });
    }

    /**
     * Get a key-value array of users that can host events.
     *
     * @return array
     */
    public static function getAvailableHosts(): array
    {
        // Get every user that can manage events
        $users = User::permission('manage events')->pluck('username', 'id');

        // Get all super admins
        $superAdmins = User::role('super admin')->pluck('username', 'id');

        // Merge the two arrays while keeping the original keys (IDs), and return them as an array
        return $users->union($superAdmins)->toArray();
    }
}
