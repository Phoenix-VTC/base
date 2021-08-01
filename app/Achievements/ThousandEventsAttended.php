<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class ThousandEventsAttended extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Attended 1000 events';

    /*
     * A small description for the achievement
     */
    public $description = 'There\'s like... No way that you achieved this. I don\'t believe it, fake news!';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 1000;
}
