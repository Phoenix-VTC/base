<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
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
