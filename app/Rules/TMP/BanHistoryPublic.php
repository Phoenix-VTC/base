<?php

namespace App\Rules\TMP;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class BanHistoryPublic implements Rule
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
            ->get("https://api.truckersmp.com/v2/player/$value")
            ->throw()
            ->json();

        if ($response['response']['permissions']['isStaff']) {
            // User is staff if bansCount is null, staff can't set their ban history to public. So return true here so they can apply anyway.
            return true;
        }

        return $response['response']['displayBans'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '
            <b>Please change your TruckersMP ban history to public before continuing.</b>
            <br>
            This can be done <a class="font-medium underline text-red-700 hover:text-red-600" href="https://truckersmp.com/profile/settings" target="_blank">here</a>. (Display your bans on your profile and API)
            <br>
            <span class="underline">Keep this on public until your application has been fully processed.</span>
        ';
    }
}
