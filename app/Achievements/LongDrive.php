<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class LongDrive extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'That\'s a long drive!';

    /*
     * A small description for the achievement
     */
    public $description = 'You submitted a job that was over 2000 kilometres.';
}
