<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class HundredEventsAttended extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Attended 100 events';

    /*
     * A small description for the achievement
     */
    public $description = 'There should probably be a reward for this amount of events.. Oh wait, that\'s what this achievement is for! Awesome work, impressive!';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 100;
}
