<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class TenScreenshots extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Post 10 screenshots';

    /*
     * A small description for the achievement
     */
    public $description = 'You\'re getting the hang of this!';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 10;
}
