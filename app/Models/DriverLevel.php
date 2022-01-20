<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class DriverLevel extends Model
{
    use Sushi;

    /**
     * All driver levels are defined here.
     *
     * Even though hard-coding rows may not be the fanciest, it will be easiest to maintain.
     * E.g. when a certain level has a required number of points (different from other levels) that wouldn't be easily calculable with a formula.
     *
     * These rows use auto-incrementing IDs. Every row is a new level, e.g. ID 1 = level 1
     *
     * Note to whoever needs to continue this, if ever: use Copilot.
     *
     * @var array
     */
    protected array $rows = [
        // Increments of 1250
        ['required_points' => 1250, 'milestone' => true],
        ['required_points' => 2500, 'milestone' => false],
        ['required_points' => 3750, 'milestone' => false],
        ['required_points' => 5000, 'milestone' => false],
        ['required_points' => 6250, 'milestone' => true],
        ['required_points' => 7500, 'milestone' => false],
        ['required_points' => 8750, 'milestone' => false],
        ['required_points' => 10000, 'milestone' => false],
        ['required_points' => 11250, 'milestone' => false],
        ['required_points' => 12500, 'milestone' => true],
        ['required_points' => 13750, 'milestone' => false],
        ['required_points' => 15000, 'milestone' => false],
        ['required_points' => 16250, 'milestone' => false],
        ['required_points' => 17500, 'milestone' => false],
        ['required_points' => 18750, 'milestone' => true],
        ['required_points' => 20000, 'milestone' => false],
        ['required_points' => 21250, 'milestone' => false],
        ['required_points' => 22500, 'milestone' => false],
        ['required_points' => 23750, 'milestone' => false],
        // Increments of 2500
        ['required_points' => 25000, 'milestone' => true],
        ['required_points' => 27500, 'milestone' => false],
        ['required_points' => 30000, 'milestone' => false],
        ['required_points' => 32500, 'milestone' => false],
        ['required_points' => 35000, 'milestone' => false],
        ['required_points' => 37500, 'milestone' => true],
        ['required_points' => 40000, 'milestone' => false],
        ['required_points' => 42500, 'milestone' => false],
        ['required_points' => 45000, 'milestone' => false],
        ['required_points' => 47500, 'milestone' => false],
        ['required_points' => 50000, 'milestone' => true],
        ['required_points' => 52500, 'milestone' => false],
        ['required_points' => 55000, 'milestone' => false],
        ['required_points' => 57500, 'milestone' => false],
        ['required_points' => 60000, 'milestone' => false],
        ['required_points' => 62500, 'milestone' => true],
        ['required_points' => 65000, 'milestone' => false],
        ['required_points' => 67500, 'milestone' => false],
        ['required_points' => 70000, 'milestone' => false],
        ['required_points' => 72500, 'milestone' => false],
        // Increments of 5000
        ['required_points' => 75000, 'milestone' => true],
        ['required_points' => 80000, 'milestone' => false],
        ['required_points' => 85000, 'milestone' => false],
        ['required_points' => 90000, 'milestone' => false],
        ['required_points' => 95000, 'milestone' => false],
        ['required_points' => 100000, 'milestone' => true],
        ['required_points' => 105000, 'milestone' => false],
        ['required_points' => 110000, 'milestone' => false],
        ['required_points' => 115000, 'milestone' => false],
        ['required_points' => 120000, 'milestone' => false],
        ['required_points' => 125000, 'milestone' => true],
        ['required_points' => 130000, 'milestone' => false],
        ['required_points' => 135000, 'milestone' => false],
        ['required_points' => 140000, 'milestone' => false],
        ['required_points' => 145000, 'milestone' => false],
        ['required_points' => 150000, 'milestone' => true],
        ['required_points' => 155000, 'milestone' => false],
        ['required_points' => 160000, 'milestone' => false],
        ['required_points' => 165000, 'milestone' => false],
        ['required_points' => 170000, 'milestone' => false],
        ['required_points' => 175000, 'milestone' => true],
    ];

    public function previous()
    {
        $previous = self::find($this->id - 1);

        return $previous ?? self::first();
    }

    public function next()
    {
        $next = self::find($this->id + 1);

        return $next ?? self::find($this->id);
    }
}
