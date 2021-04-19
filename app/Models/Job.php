<?php

namespace App\Models;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'status' => JobStatus::class,
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
}
