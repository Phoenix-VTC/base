<?php

namespace App\Rules\TMP;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class VTCHistoryPublic implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $request = Http::get('https://api.truckersmp.com/v2/player/' . $value);

        // Pass if the request failed because this isn't an important validation rule.
        if ($request->failed()) {
            return true;
        }

        return $request['response']['displayVTCHistory'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '
            <b>Please change your TruckersMP VTC history to public before continuing.</b>
            <br>
            This can be done <a class="font-medium underline text-red-700 hover:text-red-600" href="https://truckersmp.com/profile/settings" target="_blank">here</a>. (Display VTC history)
            <br>
            <span class="underline">Keep this on public until your application has been fully processed.</span>
        ';
    }
}
