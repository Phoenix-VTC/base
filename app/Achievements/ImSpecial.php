<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class ImSpecial extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'I\'m special!';

    /*
     * A small description for the achievement
     */
    public $description = 'You\'ve customized your PhoenixBase experience by changing some preferences.';
}
