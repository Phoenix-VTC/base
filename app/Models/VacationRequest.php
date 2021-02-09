<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class VacationRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
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