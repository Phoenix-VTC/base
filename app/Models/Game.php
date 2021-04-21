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
        1 => ["ETS2", "Euro Truck Simulator 2"],
        2 => ["ATS", "American Truck Simulator"]
    ];

    /**
     * Get the abbreviation of the game using the ID.
     *
     * @param int $gameId
     * @return string
     */
    public static function getAbbreviationById(int $gameId): ?string
    {
        try {
            return self::GAMES[$gameId][0];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the fully qualified name of the game using the ID.
     *
     * @param int $gameId
     * @return string
     */
    public static function getQualifiedName(int $gameId): ?string
    {
        try {
            return self::GAMES[$gameId][1];
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getAbbreviationDistanceMetric(int $gameId): ?string
    {
        if ($gameId === 1) {
            $unit = 'km';
        }

        if ($gameId === 2) {
            $unit = 'mi';
        }

        return $unit ?? null;
    }

    public static function getQualifiedDistanceMetric(int $gameId): ?string
    {
        if ($gameId === 1) {
            $unit = 'kilometres';
        }

        if ($gameId === 2) {
            $unit = 'miles';
        }

        return $unit ?? null;
    }

    public static function getAbbreviationWeightMetric(int $gameId): ?string
    {
        if ($gameId === 1) {
            $unit = 't';
        }

        if ($gameId === 2) {
            $unit = 'lb';
        }

        return $unit ?? null;
    }

    public static function getQualifiedWeightMetric(int $gameId): ?string
    {
        if ($gameId === 1) {
            $unit = 'tonnes';
        }

        if ($gameId === 2) {
            $unit = 'pounds';
        }

        return $unit ?? null;
    }
}
