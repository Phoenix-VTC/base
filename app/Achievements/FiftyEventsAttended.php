<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class FiftyEventsAttended extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Attended 50 events';

    /*
     * A small description for the achievement
     */
    public $description = 'Wooot, impressive! That\'s a lot of kilometres!';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 50;
}
