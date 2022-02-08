<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\AchievementChain;

/**
 * Class Registered
 */
class EventAttendedChain extends AchievementChain
{
    /*
     * Returns a list of instances of Achievements
     */
    public function chain(): array
    {
        return [
            new OneEventAttended(),
            new TenEventsAttended(),
            new TwentyFiveEventsAttended(),
            new FiftyEventsAttended(),
            new HundredEventsAttended(),
            new FiveHundredEventsAttended(),
            new ThousandEventsAttended(),
        ];
    }
}
