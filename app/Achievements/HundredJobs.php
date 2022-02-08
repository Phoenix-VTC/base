<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class HundredJobs extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Submitted 100 jobs';

    /*
     * A small description for the achievement
     */
    public $description = 'Oh wow, 100 jobs already! You\'re definitely getting the hang of it.';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 100;
}
