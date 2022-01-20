<?php

namespace App\Traits;

use App\Actions\Wallet\FindOrCreateWallet;
use App\Models\DriverLevel;
use Exception;
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

    /**
     * Calculate the user's driver level based on their total points (Event XP + Job XP)
     *
     * @throws Exception
     */
    public function calculateUserLevel(): DriverLevel
    {
        $levels = DriverLevel::all();

        foreach ($levels as $level) {
            // If the user's total points are greater than or equal to the required points, and less than the next level's required points, then that is the user's level.
            if ($this->totalDriverPoints() >= $level->required_points && $this->totalDriverPoints() < $level->next()->required_points) {
                return $level;
            }
        }

        // TODO: When this happens, we have ran out of levels. This should be handled nicely, so that a user does not level up (and probably notify Management)
        return throw new Exception('User level could not be calculated. This should never happen.');
    }
}
