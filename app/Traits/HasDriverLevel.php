<?php

namespace App\Traits;

use App\Actions\Wallet\FindOrCreateWallet;
use App\Models\DriverLevel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasDriverLevel
{
    private FindOrCreateWallet $findOrCreateWallet;

    public function __construct()
    {
        $this->findOrCreateWallet = new FindOrCreateWallet();
    }

    /**
     * Get the user's driver level
     *
     * @return BelongsTo
     */
    public function driverLevel(): BelongsTo
    {
        return $this->belongsTo(DriverLevel::class, 'driver_level');
    }

    /**
     * Get the user's total driver points (Event XP + Job XP)
     *
     * @return int
     */
    public function totalDriverPoints(): int
    {
        $eventXpWallet = $this->findOrCreateWallet->execute($this, 'Event XP');

        $jobXpWallet = $this->findOrCreateWallet->execute($this, 'Job XP');

        return $eventXpWallet->balance + $jobXpWallet->balance;
    }

    /**
     * Get the next level's required points
     *
     * @return int
     */
    public function nextDriverLevelPoints(): int
    {
        return $this->driverLevel->next()->required_points;
    }

    /**
     * Get the required points to reach the next level
     *
     * @return int
     */
    public function requiredPointsUntilNextLevel(): int
    {
        return $this->nextDriverLevelPoints() - $this->totalDriverPoints();
    }

    /**
     * Calculate the progress percentage towards the next level
     *
     * @return int
     */
    public function percentageUntilLevelUp(): int
    {
        return round(($this->totalDriverPoints() / $this->nextDriverLevelPoints()) * 100);
    }
}
