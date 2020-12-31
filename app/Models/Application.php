<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Application extends Model
{
    use HasFactory;
    use HasUuid;

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
     * @param $value
     * @return Collection
     */
    public function getTruckersMPDataAttribute($value): Collection
    {
        return collect(json_decode($value));
    }

    /**
     * Get the user's age.
     *
     * @return int
     */
    public function getAgeAttribute(): int
    {
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
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
}
