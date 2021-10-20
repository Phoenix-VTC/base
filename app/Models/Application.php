<?php

namespace App\Models;

use App\Concerns\HasComments;
use App\Concerns\HasUuid;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Venturecraft\Revisionable\Revisionable;

class Application extends Revisionable
{
    use HasFactory;
    use HasUuid;
    use HasComments;
    use Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the staff user that claimed the application.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimed_by');
    }

    /**
     * Get the user, if the application is accepted & not deleted.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function revisionHistoryWithUser(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable')->with('user');
    }

    /**
     * Get the user's Steam data.
     *
     * @param $value
     * @return Collection
     */
    public function getSteamDataAttribute($value): Collection
    {
        return collect(json_decode($value));
    }

    /**
     * Get the user's TruckersMP data.
     *
     * @return Collection
     */
    public function getTruckersMPDataAttribute(): Collection
    {
        return \Cache::remember($this->truckersmp_id . "_truckersmp_data", 86400, function () {
            $client = new Client();

            $response = $client->request('GET', 'https://api.truckersmp.com/v2/player/' . $this->truckersmp_id)->getBody();
            $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

            return collect($response['response']);
        });
    }

    /**
     * Get the user's TruckersMP ban history.
     *
     * @return Collection
     */
    public function getBanHistoryAttribute(): Collection
    {
        return \Cache::remember($this->truckersmp_id . "_truckersmp_ban_history", 86400, function () {
            $client = new Client();

            $response = $client->request('GET', 'https://api.truckersmp.com/v2/bans/' . $this->truckersmp_id)->getBody();
            $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

            return collect($response);
        });
    }

    /**
     * Get the user's age.
     *
     * @return int
     */
    public function getAgeAttribute(): int
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    /**
     * Get the user's application answers.
     *
     * @param $value
     * @return Collection
     */
    public function getApplicationAnswersAttribute($value): Collection
    {
        return collect(json_decode($value));
    }

    /**
     * Get whether the application has been completed.
     *
     * @return bool
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'accepted' | $this->status === 'denied';
    }

    /**
     * Route notifications for the Discord channel.
     *
     * @return string
     */
    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.hr_channel_id');
    }

    /**
     * Get the time between application creation and completion.
     *
     */
    public function getTimeUntilCompletionAttribute(): ?string
    {
        if ($this->is_completed) {
            return Carbon::parse($this->updated_at)->diffForHumans($this->created_at);
        }

        return null;
    }
}
