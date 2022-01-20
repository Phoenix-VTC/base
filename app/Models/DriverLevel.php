<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sushi\Sushi;

class DriverLevel extends Model
{
    use Sushi;

    /**
     * TODO: Actual levels are TBD
     *
     * Even though hard-coding rows may not be the fanciest, it will be easiest to maintain.
     * E.g. when a certain level has a required number of points (different from other levels) that wouldn't be easily calculable with a formula.
     *
     * Every array row uses the ID as primary key. Please make sure that this **always** increments correctly.
     * Every row (thus key) is a new level. E.g. ID 1 = level 1
     *
     * @var array|int[][]
     */
    protected array $rows = [
        ['id' => 1, 'required_points' => 0],
        ['id' => 2, 'required_points' => 200],
        ['id' => 3, 'required_points' => 300],
        ['id' => 4, 'required_points' => 400],
        ['id' => 5, 'required_points' => 500],
        ['id' => 6, 'required_points' => 600],
        ['id' => 7, 'required_points' => 700],
        ['id' => 8, 'required_points' => 800],
        ['id' => 9, 'required_points' => 900],
        ['id' => 10, 'required_points' => 1000],
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
