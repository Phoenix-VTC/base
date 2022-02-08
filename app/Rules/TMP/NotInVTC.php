<?php

namespace App\Rules\TMP;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class NotInVTC implements Rule
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

        if ($response['response']['vtc']['id'] === 30294) {
            // Return true if the VTC is Phoenix
            return true;
        }

        return ! $response['response']['vtc']['inVTC'];
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
