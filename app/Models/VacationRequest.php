<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Models\VacationRequest
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $handled_by
 * @property string $reason
 * @property bool $leaving
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $duration
 * @property-read bool $is_active
 * @property-read bool $is_expired
 * @property-read bool $is_upcoming
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @property-read \App\Models\User|null $staff
 * @property-read \App\Models\User $user
 * @method static Builder|VacationRequest newModelQuery()
 * @method static Builder|VacationRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|VacationRequest onlyTrashed()
 * @method static Builder|VacationRequest query()
 * @method static Builder|VacationRequest whereCreatedAt($value)
 * @method static Builder|VacationRequest whereDeletedAt($value)
 * @method static Builder|VacationRequest whereEndDate($value)
 * @method static Builder|VacationRequest whereHandledBy($value)
 * @method static Builder|VacationRequest whereId($value)
 * @method static Builder|VacationRequest whereLeaving($value)
 * @method static Builder|VacationRequest whereReason($value)
 * @method static Builder|VacationRequest whereStartDate($value)
 * @method static Builder|VacationRequest whereUpdatedAt($value)
 * @method static Builder|VacationRequest whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|VacationRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|VacationRequest withoutTrashed()
 * @mixin \Eloquent
 */
class VacationRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    use RevisionableTrait;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'leaving' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by')->withTrashed();
    }

    public function revisionHistoryWithUser(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable')->with('user');
    }

    public function getIsExpiredAttribute(): bool
    {
        return Carbon::parse($this->end_date)->isPast();
    }

    public function getIsActiveAttribute(): bool
    {
        return (Carbon::parse($this->start_date)->isPast() && Carbon::parse($this->end_date)->isFuture());
    }

    public function getIsUpcomingAttribute(): bool
    {
        return Carbon::parse($this->start_date)->isFuture();
    }

    public function getDurationAttribute(): string
    {
        return Carbon::parse($this->end_date)->diffForHumans($this->start_date, short: true);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotLeaving(Builder $query): Builder
    {
        return $query->where('leaving', false);
    }

    /**
     * Route notifications for the Discord HR channel.
     *
     * @return string
     */
    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.channels.human-resources');
    }
}
