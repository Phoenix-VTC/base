<?php

namespace App\Rules\TMP;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class BanHistoryPublic implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws \JsonException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function passes($attribute, $value): bool
    {
        $client = new Client();

        $response = $client->request('GET', 'https://api.truckersmp.com/v2/player/' . $value)->getBody();
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

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
