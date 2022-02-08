<?php

declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 */
class MoneyMan extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'Money man!';

    /*
     * A small description for the achievement
     */
    public $description = 'You submitted a job with more than 100.000 USD / EUR of total income.';
}
