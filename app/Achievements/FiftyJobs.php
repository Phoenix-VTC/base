<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class FiftyJobs extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Submitted 50 jobs';

    /*
     * A small description for the achievement
     */
    public $description = 'You have submitted 50 jobs! Nice work';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 50;
}
