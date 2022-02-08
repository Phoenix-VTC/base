<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class TwentyFiveEventsAttended extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Attended 25 events';

    /*
     * A small description for the achievement
     */
    public $description = 'Look at you! 25 events is a pretty impressive amount.';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 25;
}
