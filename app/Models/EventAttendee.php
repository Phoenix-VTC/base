<?php

namespace App\Models;

use App\Enums\Attending;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EventAttendee
 *
 * @property int $id
 * @property int $user_id
 * @property int $event_id
 * @property Attending|int $attending
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\EventAttendeeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereAttending($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventAttendee whereUserId($value)
 * @mixin \Eloquent
 */
class EventAttendee extends Model
{
    use HasFactory;

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
        'attending' => Attending::class,
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
