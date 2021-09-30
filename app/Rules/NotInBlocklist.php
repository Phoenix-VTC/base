<?php

namespace App\Rules;

use App\Events\UserInBlocklistTriedToApply;
use App\Models\Blocklist;
use Illuminate\Contracts\Validation\Rule;

class NotInBlocklist implements Rule
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
        $query = Blocklist::query()->exactSearch($value);

        // Pass if the value doesn't exist
        if ($query->doesntExist()) {
            return true;
        }

        event(new UserInBlocklistTriedToApply($value));

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '
            <b>You have been blocked from joining PhoenixVTC.</b>
            <br>
            If you think that this is an error, please contact our Human Resources department at <a href="mailto:hr@phoenixvtc.com" class="font-bold">hr@phoenixvtc.com</a>.
            ';
    }
}
