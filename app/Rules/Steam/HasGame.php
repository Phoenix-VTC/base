<?php

namespace App\Rules\Steam;

use Illuminate\Contracts\Validation\Rule;

class HasGame implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $games = \Steam::player($value)->GetOwnedGames();

        $games = $games->contains(function ($value) {
            return (
                $value->appId === 227300 ||
                $value->appId === 270880
            );
        });

        return $games;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'It looks like you do not have Euro Truck Simulator 2 <strong>or</strong> American Truck Simulator purchased.<br>Please make sure that you are using the correct Steam account.';
    }
}
