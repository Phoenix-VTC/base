<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class TenJobs extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Submitted 10 jobs';

    /*
     * A small description for the achievement
     */
    public $description = 'Nice, you have submitted 10 jobs! It looks like you\'re getting the hang of it.';

    /*
    * The amount of "points" this user need to obtain in order to complete this achievement
    */
    public $points = 10;
}
