<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class FiftyScreenshots extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Post 50 screenshots';

    /*
     * A small description for the achievement
     */
    public $description = 'You\'re an influencer now. Yassss, you go girl!';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 50;
}
