<?php

namespace App\Rules\TMP;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class UniqueInUsers implements Rule
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

        return !(bool)User::where('steam_id', $response['response']['steamID64'])->orWhere('truckersmp_id', $response['response']['id'])->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '
            <b>It looks like you already are a member of Phoenix.</b>
            <br>
            If you think that this is an error, please contact our support.
        ';
    }
}
