<?php

namespace App\Rules\TMP;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class NoRecentBans implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function passes($attribute, $value): bool
    {
        $client = new Client();

        $response = $client->request('GET', 'https://api.truckersmp.com/v2/bans/' . $value)->getBody();
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (!$response['error'] && !$response['response']) {
            return true; // Return true if the user has no bans
        }

        $bans = collect($response['response']);
        $ban = $bans->firstWhere('expiration', '>', Carbon::now()->subMonths(3));
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
