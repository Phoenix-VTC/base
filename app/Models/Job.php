<?php

namespace App\Models;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Venturecraft\Revisionable\RevisionableTrait;

class Job extends Model
{
    use HasFactory;
    use RevisionableTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'status' => JobStatus::class,
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'created_at' => 'datetime',
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
     * @return int
     */
    public function getPricePerDistanceAttribute(): int
    {
        return round($this->estimated_income / $this->distance, 2);
    }
}
