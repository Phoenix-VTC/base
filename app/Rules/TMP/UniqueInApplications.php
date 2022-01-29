<?php

namespace App\Rules\TMP;

use App\Models\Application;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class UniqueInApplications implements Rule
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

        return Application::query()
            ->where(function (Builder $query) use ($response) {
                $query->whereJsonContains('steam_data->steamID64', $response['response']['steamID64'])
                    ->orWhere('truckersmp_id', $response['response']['id']);
            })->whereNotIn('status', ['accepted', 'denied'])
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '
            <b>It looks like you already submitted an application.</b>
            <br>
            You will receive an email once your application has been processed.
            <br>
            If you think that this is an error, please contact our support.
        ';
    }
}
