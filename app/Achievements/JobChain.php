<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 */
class JobChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new OneJob(),
            new TenJobs(),
            new FiftyJobs(),
            new HundredJobs(),
            new FiveHundredJobs(),
            new ThousandJobs(),
        ];
    }
}
