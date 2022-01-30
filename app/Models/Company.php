<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string|null $category
 * @property string|null $specialization
 * @property string|null $dlc
 * @property string|null $mod
 * @property int $game_id
 * @property bool $approved
 * @property int|null $requested_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $destinationJobs
 * @property-read int|null $destination_jobs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $pickupJobs
 * @property-read int|null $pickup_jobs_count
 * @property-read \App\Models\User|null $requester
 * @method static Builder|Company dropdownSearch(string $term)
 * @method static \Database\Factories\CompanyFactory factory(...$parameters)
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company search(string $term)
 * @method static Builder|Company whereApproved($value)
 * @method static Builder|Company whereCategory($value)
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereDlc($value)
 * @method static Builder|Company whereGameId($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereMod($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereRequestedBy($value)
 * @method static Builder|Company whereSpecialization($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = [];

    protected $casts = [
        'approved' => 'boolean',
    ];

    /**
     * The jobs with this company as pickup.
     */
    public function pickupJobs(): HasMany
    {
        return $this->hasMany(Job::class, 'pickup_company_id');
    }

    /**
     * The jobs with this company as destination.
     */
    public function destinationJobs(): HasMany
    {
        return $this->hasMany(Job::class, 'destination_company_id');
    }

    /**
     * Get the user that requested the cargo.
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function scopeSearch($query, string $term): Builder
    {
        return $query->where(
            fn($query) => $query->where('name', 'like', '%' . $term . '%')
        );
    }

    public function scopeDropdownSearch($query, string $term): Collection
    {
        return $this->search($term)
            ->limit(10)
            ->pluck('name', 'id');
    }
}
