<?php

namespace App\Models;

use App\Enums\JobStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * App\Models\Job
 *
 * @property int $id
 * @property int $user_id
 * @property int $game_id
 * @property int $pickup_city_id
 * @property int $destination_city_id
 * @property int $pickup_company_id
 * @property int $destination_company_id
 * @property int $cargo_id
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $finished_at
 * @property int $distance
 * @property int|float $load_damage
 * @property int $estimated_income
 * @property int $total_income
 * @property string|null $comments
 * @property JobStatus|int $status
 * @property bool $tracker_job
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cargo $cargo
 * @property-read \App\Models\City $destinationCity
 * @property-read \App\Models\Company $destinationCompany
 * @property-read bool $can_edit
 * @property-read bool $has_pending_game_data
 * @property-read int $price_per_distance
 * @property-read \App\Models\City $pickupCity
 * @property-read \App\Models\Company $pickupCompany
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Revision[] $revisionHistoryWithUser
 * @property-read int|null $revision_history_with_user_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\JobFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCargoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDestinationCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDestinationCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereEstimatedIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereLoadDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePickupCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePickupCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereTotalIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereTrackerJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUserId($value)
 * @mixin \Eloquent
 */
class Job extends Model
{
    use HasFactory;
    use RevisionableTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = [];

    protected $casts = [
        'status' => JobStatus::class,
        'tracker_job' => 'boolean',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'created_at' => 'datetime',
        'verified_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the job.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pickup city associated with the job.
     */
    public function pickupCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the destination city associated with the job.
     */
    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the pickup company associated with the job.
     */
    public function pickupCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the destination company associated with the job.
     */
    public function destinationCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the cargo associated with the job.
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    public function revisionHistoryWithUser(): MorphMany
    {
        return $this->morphMany(Revision::class, 'revisionable')->with('user');
    }

    /**
     * Convert the estimated income to euros if game is ATS
     *
     * @param int $value
     * @return void
     */
    public function setEstimatedIncomeAttribute(int $value): void
    {
        if ($this->attributes['game_id'] === 2) {
            $value *= 0.83;
        }

        $this->attributes['estimated_income'] = round($value);
    }

    /**
     * Convert the total income to euros if game is ATS
     *
     * @param int $value
     * @return void
     */
    public function setTotalIncomeAttribute(int $value): void
    {
        if ($this->attributes['game_id'] === 2) {
            $value *= 0.83;
        }

        $this->attributes['total_income'] = round($value);
    }

    /**
     * Convert the distance to kilometres if game is ATS
     *
     * @param int $value
     * @return void
     */
    public function setDistanceAttribute(int $value): void
    {
        if ($this->attributes['game_id'] === 2) {
            $value *= 1.609;
        }

        $this->attributes['distance'] = round($value);
    }

    /**
     * Calculate the price per distance
     *
     * @return int|float
     */
    public function getPricePerDistanceAttribute(): int|float
    {
        try {
            return round($this->estimated_income / $this->distance, 2);
        } catch (\ErrorException $e) {
            return 0;
        }
    }

    /**
     * Check if the job has any pending game data
     *
     * @return bool
     */
    public function hasPendingGameData(): bool
    {
        return !($this->pickupCompany->approved && $this->destinationCompany->approved && $this->pickupCity->approved && $this->destinationCity->approved && $this->cargo->approved);
    }

    /**
     * Get the date the job was submitted.
     *
     * If a tracker job, verified_at should be returned.
     * Otherwise, created_at should be returned.
     *
     * @return Carbon
     */
    public function submittedAt(): Carbon
    {
        if ($this->tracker_job && $this->verified_at) {
            return $this->verified_at;
        }

        return $this->created_at;
    }

    /**
     * Check if the job status is 'complete'
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status->value === JobStatus::Complete;
    }
}
