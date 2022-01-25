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
use Illuminate\Support\Str;
use Venturecraft\Revisionable\Revisionable;

/**
 * App\Models\Application
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $claimed_by
 * @property string $username
 * @property string $email
 * @property string|null $discord_username
 * @property string $date_of_birth
 * @property string $country
 * @property Collection $steam_data
 * @property int $truckersmp_id
 * @property Collection $application_answers
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read int $age
 * @property-read Collection $ban_history
 * @property-read bool $is_completed
 * @property-read string|null $time_until_completion
 * @property-read Collection $truckers_m_p_data
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ApplicationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicationAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereClaimedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDiscordUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSteamData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTruckersmpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUuid($value)
 * @mixin \Eloquent
 */
class Application extends Revisionable
{
    use HasFactory;
    use HasUuid;
    use HasComments;
    use Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = [];

    protected $casts = [
        'steam_data' => 'collection',
        'application_answers' => 'collection',
    ];

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
     * Get whether the application has been completed.
     *
     * @return bool
     */
    public function getIsCompletedAttribute(): bool
    {
        return in_array($this->status, ['accepted', 'denied']);
    }

    /**
     * Route notifications for the Discord channel.
     *
     * @return string
     */
    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.channels.human-resources');
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
