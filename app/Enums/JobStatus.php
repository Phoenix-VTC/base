<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Incomplete()
 * @method static static PendingVerification()
 * @method static static Complete()
 */
final class JobStatus extends Enum
{
    public const Incomplete = 0;

    public const PendingVerification = 1;

    public const Complete = 2;
}
