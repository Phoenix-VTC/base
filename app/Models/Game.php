<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Game
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @mixin \Eloquent
 */
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
     * @return string|null
     */
    public static function getAbbreviationById(int $gameId): ?string
    {
        $game = self::GAMES[$gameId] ?? [];

        return $game[0] ?? null;
    }

    /**
     * Get the fully qualified name of the game using the ID.
     *
     * @param int $gameId
     * @return string|null
     */
    public static function getQualifiedName(int $gameId): ?string
    {
        $game = self::GAMES[$gameId] ?? [];

        return $game[1] ?? null;
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

    public static function getCurrencySymbol(int $gameId): ?string
    {
        if ($gameId === 1) {
            $currency = '€';
        }

        if ($gameId === 2) {
            $currency = '$';
        }

        return $currency ?? null;
    }
}
