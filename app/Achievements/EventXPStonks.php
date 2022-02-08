<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class EventXPStonks extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'XP Stonks!';

    /*
     * A small description for the achievement
     */
    public $description = 'You attended an event with 500 XP as it\'s reward!';
}
