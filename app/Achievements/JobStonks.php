<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class JobStonks extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Stonks!';

    /*
     * A small description for the achievement
     */
    public $description = 'You submitted a job with >200.000 USD / EUR of total income, and over 2200 kilometres.';
}
