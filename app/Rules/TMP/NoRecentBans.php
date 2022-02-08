<?php

namespace App\Rules\TMP;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class NoRecentBans implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws RequestException
     */
    public function passes($attribute, $value): bool
    {
        $response = Http::timeout(3)
            ->get("https://api.truckersmp.com/v2/bans/$value")
            ->throw()
            ->json();

        // Return true if the user has no bans
        if (! $response['error'] && ! $response['response']) {
            return true;
        }

        $bans = collect($response['response']);
        $ban = $bans->firstWhere('timeAdded', '>', Carbon::now()->subMonths(3));

        // Return true if the ban is a @BANBYMISTAKE
        if (isset($ban) && $ban['reason'] === '@BANBYMISTAKE') {
            return true;
        }

        return is_null($ban);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '
            <b>It looks like you were banned on TruckersMP within the last three months.</b>
            <br>
            Please wait until your most recent ban is at least three months old before applying to Phoenix.
        ';
    }
}
