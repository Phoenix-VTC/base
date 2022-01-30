<?php

namespace App\Http\Livewire\Auth\Passwords;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;
use Illuminate\Support\Facades\Password;

class Email extends Component
{
    use WithRateLimiting;

    /** @var string */
    public string $email = '';

    /** @var string|bool|null */
    public string|bool|null $emailSentMessage = false;

    public function sendResetPasswordLink()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            $this->addError('email', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to reset your password.");

            return;
        }

        $this->validate([
            'email' => ['bail', 'required', 'string', 'email'],
        ]);

        $response = $this->broker()->sendResetLink(['email' => $this->email]);

        if ($response == Password::RESET_LINK_SENT) {
            $this->emailSentMessage = trans($response);

            return;
        }

        $this->addError('email', trans($response));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    public function render()
    {
        return view('livewire.auth.passwords.email')->extends('layouts.auth');
    }
}
