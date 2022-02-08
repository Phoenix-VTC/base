<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class HundredScreenshots extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Post 100 screenshots';

    /*
     * A small description for the achievement
     */
    public $description = 'How did you even get this achievement, that\'s a lotta screenshots.';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 100;
}
