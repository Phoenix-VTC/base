<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Models\Cargo
 *
 * @property int $id
 * @property string $name
 * @property string|null $dlc
 * @property string|null $mod
 * @property int|null $weight
 * @property int|null $game_id
 * @property int $world_of_trucks
 * @property bool $approved
 * @property int|null $requested_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Job[] $jobs
 * @property-read int|null $jobs_count
 * @property-read \App\Models\User|null $requester
 * @method static Builder|Cargo dropdownSearch(string $term)
 * @method static \Database\Factories\CargoFactory factory(...$parameters)
 * @method static Builder|Cargo newModelQuery()
 * @method static Builder|Cargo newQuery()
 * @method static Builder|Cargo query()
 * @method static Builder|Cargo search(string $term)
 * @method static Builder|Cargo whereApproved($value)
 * @method static Builder|Cargo whereCreatedAt($value)
 * @method static Builder|Cargo whereDlc($value)
 * @method static Builder|Cargo whereGameId($value)
 * @method static Builder|Cargo whereId($value)
 * @method static Builder|Cargo whereMod($value)
 * @method static Builder|Cargo whereName($value)
 * @method static Builder|Cargo whereRequestedBy($value)
 * @method static Builder|Cargo whereUpdatedAt($value)
 * @method static Builder|Cargo whereWeight($value)
 * @method static Builder|Cargo whereWorldOfTrucks($value)
 * @mixin \Eloquent
 */
class Cargo extends Model
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
     * The jobs with this cargo.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
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
