<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class OneScreenshot extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Post one screenshot';

    /*
     * A small description for the achievement
     */
    public $description = 'The first of many!';
}
