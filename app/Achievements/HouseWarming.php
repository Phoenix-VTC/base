<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class HouseWarming extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'House warming!';

    /*
     * A small description for the achievement
     */
    public $description = 'You hauled a turnkey house. Pretty cozy, right?';
}
