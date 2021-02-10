<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * Lookup array for the Games.
     *
     * The array key is the ID of the Game and the value is an array for the name of the game
     * beginning with an abbreviation then followed by a fully qualified name.
     */
    public const GAMES = [
        1 => ["ETS 2", "Euro Truck Simulator 2"],
        2 => ["ATS", "American Truck Simulator"]
    ];

    /**
     * Get the abbreviation of the game using the ID.
     *
     * @param int $gameId
     * @return string
     */
    public static function getAbbreviationById(int $gameId): string
    {
        return self::GAMES[$gameId][0];
    }

    /**
     * Get the fully qualified name of the game using the ID.
     *
     * @param int $gameId
     * @return string
     */
    public static function getQualifiedName(int $gameId): string
    {
        return self::GAMES[$gameId][1];
    }
}
