<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DiscordController extends Controller
{
    /**
     * The redirect URL.
     *
     * @var string
     */
    protected string $redirectURL = '/';

    public function redirectToDiscord(): RedirectResponse
    {
        return Socialite::driver('discord')->redirect();
    }

    public function handle()
    {
        try {
            $discord_user = Socialite::driver('discord')->user();

            // Update/add the Discord data if the user is authenticated
            if (Auth::check()) {
                $user = Auth::user();

                $data = [
                    'id' => $discord_user->getId(),
                    'name' => $discord_user->getName(),
                    'nickname' => $discord_user->getNickname(),
                    'avatar' => $discord_user->getAvatar(),
                ];

                // If the user doesn't have a Discord account connected, and the Discord ID already exists with another user
                if (is_null($user->discord) && User::whereJsonContains('discord->id', $discord_user->getId())->count()) {
                    session()->flash('alert', [
                        'type' => 'danger',
                        'title' => 'Hmm, this is strange.',
                        'message' => 'It looks like this Discord account is already connected to another user.<br>Please contact support if this issue persists.'
                    ]);

                    return redirect()->route('settings.socials');
                }

                $user->discord = $data;
                $user->save();

                session()->flash('alert', ['type' => 'success', 'message' => 'Discord data successfully updated!']);

                return redirect()->route('settings.socials');
            }

            // User isn't authenticated, try to log in
            $user = User::whereJsonContains('discord->id', $discord_user->getId())->first();

            if (is_null($user)) {
                return redirect()
                    ->route('login')
                    ->withErrors(['socialAuth' => [
                        'title' => 'Hmm, are you a Phoenix Member?',
                        'message' => '
                        We couldn\'t link any Phoenix accounts to the Discord account that you used.
                        <br>
                        If you\'re trying to apply to Phoenix, please do this <a href="https://phoenixvtc.com/en/apply" class="font-bold">here</a>.
                    '
                    ]]);
            }

            Auth::login($user);

            return redirect($this->redirectURL);
        } catch (InvalidStateException $e) {
            return $this->redirectToDiscord();
        } catch (BadResponseException | GuzzleException $e) {
            return redirect()
                ->route('login')
                ->withErrors(['socialAuth' => [
                    'title' => 'Can you try that again?',
                    'message' => '
                        Something went wrong while trying to login with Discord
                        <br>
                        If this error keeps occurring, please contact our support.
                    '
                ]]);
        }
    }
}
