<?php

namespace App\Rules\TMP;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class AccountExists implements Rule
{
    private array $response;

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
        $this->response = Http::timeout(3)
            ->get("https://api.truckersmp.com/v2/player/$value")
            ->throw()
            ->json();

        return ! $this->response['error'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "<b>TruckersMP Error: </b> {$this->response['response']}";
    }
}
