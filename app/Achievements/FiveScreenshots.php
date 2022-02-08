<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class FiveScreenshots extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Post 5 screenshots';

    /*
     * A small description for the achievement
     */
    public $description = 'How many likes to you have? 👀';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 5;
}
