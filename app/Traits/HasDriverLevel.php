<?php

namespace App\Traits;

use App\Actions\Wallet\FindOrCreateWallet;
use App\Models\DriverLevel;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasDriverLevel
{
    /**
     * Get the user's driver level
     *
     * @return BelongsTo
     */
    public function driverLevel(): BelongsTo
    {
        return $this->belongsTo(DriverLevel::class, 'driver_level')->withDefault();
    }

    /**
     * Get the user's total driver points (Event XP + Job XP)
     *
     * @return int
     */
    public function totalDriverPoints(): int
    {
        $eventXpWallet = (new FindOrCreateWallet())->execute($this, 'Event XP');

        $jobXpWallet = (new FindOrCreateWallet())->execute($this, 'Job XP');

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
     * This can be calculated by `(totalPoints - currentLevelPoints) / (nextLevelPoints - currentLevelPoints) * 100`
     *
     * @return int
     */
    public function percentageUntilLevelUp(): int
    {
        return round(($this->totalDriverPoints() - $this->driverLevel->required_points) / ($this->nextDriverLevelPoints() - $this->driverLevel->required_points) * 100);
    }

    /**
     * Get the user's previous milestone level
     * This can be useful when "downgrading" a user to a lower level, and their Discord role needs to be updated
     *
     * @return int
     */
    public function previousMilestoneLevel(): int
    {
        return DriverLevel::query()
            ->where('id', '<', $this->driver_level)
            ->where('milestone', true)
            ->orderByDesc('id')
            ->first()
            ->id;
    }

    /**
     * Calculate the user's driver level based on their total points (Event XP + Job XP)
     *
     * @throws Exception
     */
    public function calculateUserLevel(): int
    {
        $levels = DriverLevel::all();

        foreach ($levels as $level) {
            // If the user's total driver points are 0, return 0 (since there is no level with 0 as the required points)
            if ($this->totalDriverPoints() === 0) {
                return 0;
            }

            // If the user's total points are greater than or equal to the required points, and less than the next level's required points, then that is the user's level.
            if ($this->totalDriverPoints() >= $level->required_points && $this->totalDriverPoints() < $level->next()->required_points) {
                return $level->id;
            }
        }

        // TODO: When this happens, we have ran out of levels or something went horribly wrong.
        //  This should be handled nicely, so that a user does not level up (and probably notify Management)
        return throw new Exception('User level could not be calculated. This should never happen.');
    }
}
