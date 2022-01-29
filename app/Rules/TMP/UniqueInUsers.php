<?php

namespace App\Rules\TMP;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class UniqueInUsers implements Rule
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
