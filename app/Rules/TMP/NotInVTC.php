<?php

namespace App\Rules\TMP;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class NotInVTC implements Rule
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

        return !$response['response']['vtc']['inVTC'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '
            <b>It looks like you currently are in a VTC.</b>
            <br>
            You must first fully leave this VTC before you can apply to Phoenix.
        ';
    }
}
