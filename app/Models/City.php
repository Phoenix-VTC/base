<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $real_name
 * @property string $name
 * @property string $country
 * @property string|null $dlc
 * @property string|null $mod
 * @property int|null $game_id
 * @property int|null $x
 * @property int|null $z
 * @property bool $approved
 * @property int|null $requested_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $destinationJobs
 * @property-read int|null $destination_jobs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $pickupJobs
 * @property-read int|null $pickup_jobs_count
 * @property-read \App\Models\User|null $requester
 * @method static Builder|City dropdownSearch(string $term)
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City search(string $term)
 * @method static Builder|City whereApproved($value)
 * @method static Builder|City whereCountry($value)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereDlc($value)
 * @method static Builder|City whereGameId($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereMod($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereRealName($value)
 * @method static Builder|City whereRequestedBy($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @method static Builder|City whereX($value)
 * @method static Builder|City whereZ($value)
 * @mixin \Eloquent
 */
class City extends Model
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
     * The jobs with this city as pickup.
     */
    public function pickupJobs(): HasMany
    {
        return $this->hasMany(Job::class, 'pickup_city_id');
    }

    /**
     * The jobs with this city as destination.
     */
    public function destinationJobs(): HasMany
    {
        return $this->hasMany(Job::class, 'destination_city_id');
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
            fn($query) => $query->where('real_name', 'like', '%' . $term . '%')
        );
    }

    public function scopeDropdownSearch($query, string $term): Collection
    {
        return $this->search($term)
            ->limit(10)
            ->get()
            ->mapWithKeys(function (City $city) {
                return [
                    $city->id => $city->getDropdownName(),
                ];
            });
    }

    public function getDropdownName()
    {
        if ($this->mod) {
            return $this->real_name . ' (' . $this->mod . ')';
        }

        return $this->real_name;
    }
}
