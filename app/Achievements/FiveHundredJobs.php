<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class FiveHundredJobs extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Submitted 500 jobs';

    /*
     * A small description for the achievement
     */
    public $description = '500 jobs? No way. That\'s a big achievement! Let\'s get to 1000 next, yes?';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 500;
}
