<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Attending extends Enum
{
    public const No = 0;
    public const Yes = 1;
    public const Maybe = 2;
}
