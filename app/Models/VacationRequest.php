<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Venturecraft\Revisionable\RevisionableTrait;

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
        return Carbon::parse($this->end_date)->diffForHumans($this->start_date, true);
    }

    /**
     * Route notifications for the Discord HR channel.
     *
     * @return string
     */
    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.hr_channel_id');
    }
}
