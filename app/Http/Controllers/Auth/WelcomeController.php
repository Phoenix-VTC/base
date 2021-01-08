<?php

namespace App\Http\Controllers\Auth;

use Spatie\WelcomeNotification\WelcomeController as BaseWelcomeController;

class WelcomeController extends BaseWelcomeController
{
    public string $redirectTo = '/';

    protected function rules(): array
    {
        return [
            'password' => 'required|confirmed|min:8',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
