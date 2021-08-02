<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class ThousandJobs extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Submitted 1000 jobs';

    /*
     * A small description for the achievement
     */
    public $description = '1000 jobs? Wow, I\'m lost for words. That\'s simply amazing.';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 1000;
}
