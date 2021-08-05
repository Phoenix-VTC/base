<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class TenEventsAttended extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Attended 10 events';

    /*
     * A small description for the achievement
     */
    public $description = 'You\'re getting the hang of this!';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 10;
}
