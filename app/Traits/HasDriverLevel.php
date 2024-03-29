<?php

namespace App\Traits;

use App\Actions\Wallet\FindOrCreateWallet;
use App\Models\DriverLevel;
use DivisionByZeroError;
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
        if ($this->driverLevel->next()->id === $this->driver_level) {
            return 100;
        }

        // This is inside a try/catch because DivisionByZeroError is thrown when the user has the maximum level
        try {
            $percentage = round(($this->totalDriverPoints() - $this->driverLevel->required_points) / ($this->nextDriverLevelPoints() - $this->driverLevel->required_points) * 100);
        } catch (DivisionByZeroError) {
            $percentage = 0;
        }

        // Return the percentage, but make sure it's never above 100
        return min($percentage, 100);
    }

    /**
     * Get the user's points starting from the current level
     *
     * @return int
     */
    public function pointsFromLevelUp(): int
    {
        return $this->totalDriverPoints() - $this->driverLevel->required_points;
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
        // If the user's total driver points are 0, return 0 (since there is no level with 0 as the required points).
        if ($this->totalDriverPoints() === 0) {
            return 0;
        }

        // If the user's total driver points are below the first level's required points, their level is 0.
        if ($this->totalDriverPoints() < DriverLevel::query()->first()->required_points) {
            return 0;
        }

        $levels = DriverLevel::all();

        foreach ($levels as $level) {
            // If the user's total points are greater than or equal to this level's required points, and less than the next level's required points, then that is the user's level.
            if ($this->totalDriverPoints() >= $level->required_points && $this->totalDriverPoints() < $level->next()->required_points) {
                return $level->id;
            }

            // If the user's total points are greater than or equal to this level's required points, and the next level is this level, then that is the user's level.
            // The only use case for this is when we have run out of levels.
            if ($this->totalDriverPoints() >= $level->required_points && $level->next()->id === $level->id) {
                return $level->id;
            }
        }

        // This should basically never happen
        return throw new Exception('User level could not be calculated. This should never happen.');
    }
}
