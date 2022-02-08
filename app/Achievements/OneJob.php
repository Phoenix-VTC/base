<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class OneJob extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Submitted one job';

    /*
     * A small description for the achievement
     */
    public $description = 'You have submitted your first job! Nice work, and keep going!';
}
