<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class UserSetAProfileBanner extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Set a profile banner';

    /*
     * A small description for the achievement
     */
    public $description = 'Nice! You have set a profile banner.';
}
