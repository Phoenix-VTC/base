<?php

namespace App\Http\Livewire\Auth;

use App\Events\UserInBlocklistAuthenticated;
use App\Models\Blocklist;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    use WithRateLimiting;

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => ['bail', 'required', 'string', 'email'],
        'password' => ['bail', 'required', 'string'],
    ];

    public function authenticate()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            $this->addError('email', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to log in.");

            return;
        }

        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        $this->blocklistCheck();

        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }

    private function blocklistCheck(): void
    {
        $userValues = Auth::user()->only(['id', 'username', 'email', 'steam_id', 'truckersmp_id', 'discord']);

        foreach ($userValues as $value) {
            // Continue to next iteration if the value is null/empty
            if (! isset($value)) {
                continue;
            }

            // If the value is an array AND the key ID exists, use that as the value (since 'discord' returns is an array)
            if (is_array($value) && array_key_exists('id', $value)) {
                $value = $value['id'];
            }

            $query = Blocklist::query()->exactSearch($value);

            if ($query->exists()) {
                event(new UserInBlocklistAuthenticated(Auth::user(), $value));
            }
        }
    }
}
