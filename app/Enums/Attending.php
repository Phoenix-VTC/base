<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 */
final class Attending extends Enum
{
    public const Yes = 1;
    public const Maybe = 2;
}
