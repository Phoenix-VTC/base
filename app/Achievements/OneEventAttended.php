<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class OneEventAttended extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Attended one event';

    /*
     * A small description for the achievement
     */
    public $description = 'Well done! Did you enjoy the event?';
}
