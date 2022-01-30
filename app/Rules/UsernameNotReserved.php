<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsernameNotReserved implements Rule
{
    /**
     * Array of reserved usernames.
     * These need to be in lower case, with only alphanumeric characters.
     *
     * @var array
     */
    private array $reserved_usernames = [
        'admin',
        'owner',
        'staff',
        'phoenix',
        'phoenixvtc',
        'truckersmp',
        'truckersfm',
        'tmp',
        'tfm',
    ];

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !in_array($this->stripValue($value), $this->reserved_usernames, false);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The username is reserved, please choose a different username.';
    }

    /**
     * Strip the value to only alphanumeric chars.
     *
     * @param string $value
     * @return string
     */
    private function stripValue(string $value): string
    {
        $stripped_value = preg_replace("/[^a-zA-Z0-9]/", "", $value);

        return strtolower($stripped_value);
    }
}
