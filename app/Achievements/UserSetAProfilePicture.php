<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class UserSetAProfilePicture extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Set a profile picture';

    /*
     * A small description for the achievement
     */
    public $description = 'Nice! You have set a profile picture.';
}
