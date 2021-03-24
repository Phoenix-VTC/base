<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Yes()
 * @method static static Maybe()
 */
final class Attending extends Enum
{
    public const Yes = 1;
    public const Maybe = 2;
}
