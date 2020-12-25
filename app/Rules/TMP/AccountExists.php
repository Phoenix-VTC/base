<?php

namespace App\Rules\TMP;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class AccountExists implements Rule
{
    private $response;

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

        $this->response = $client->request('GET', 'https://api.truckersmp.com/v2/player/' . $value)->getBody();
        $this->response = json_decode($this->response, true, 512, JSON_THROW_ON_ERROR);

        return !$this->response['error'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '<b>TruckersMP Error: </b>' . $this->response['response'];
    }
}
