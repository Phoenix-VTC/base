<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class FiveHundredEventsAttended extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Attended 500 events';

    /*
     * A small description for the achievement
     */
    public $description = 'You *only* attended 500 events? Such a noob :kappa:. Just kidding! I don\'t think that many other drivers will get this achievement.';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 500;
}
