<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Invisnik\LaravelSteamAuth\SteamAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SteamController extends Controller
{
    /**
     * The SteamAuth instance.
     *
     * @var SteamAuth
     */
    protected SteamAuth $steam;

    /**
     * The redirect URL.
     *
     * @var string
     */
    protected string $redirectURL = '/';

    /**
     * AuthController constructor.
     *
     * @param SteamAuth $steam
     */
    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    /**
     * Redirect the user to the authentication page
     *
     * @return RedirectResponse|Redirector
     */
    public function redirectToSteam()
    {
        return $this->steam->redirect();
    }

    /**
     * Get user info and log in
     *
     * @return RedirectResponse|Redirector
     */
    public function handle()
    {
        try {
            if ($this->steam->validate()) {
                $info = $this->steam->getUserInfo();

                if (!is_null($info)) {
                    $user = $this->findUserOrNull($info);

                    // If the user couldn't be found
                    if (is_null($user)) {
                        return redirect()
                            ->route('login')
                            ->withErrors(['socialAuth' => [
                                'title' => 'Hmm, are you a Phoenix Member?',
                                'message' => '
                                    We couldn\'t link any Phoenix accounts to the Steam account that you used.
                                    <br>
                                    If you\'re trying to apply to Phoenix, please do this <a href="https://phoenixvtc.com/en/apply" class="font-bold">this</a> here.
                                '
                            ]]);
                    }

                    Auth::login($user, true);

                    return redirect($this->redirectURL);
                }
            }
        } catch (BadResponseException | GuzzleException $e) {
            return redirect()
                ->route('login')
                ->withErrors(['socialAuth' => [
                    'title' => 'Can you try that again?',
                    'message' => '
                        Something went wrong while trying to login with Steam
                        <br>
                        If this error keeps occurring, please contact our support.
                    '
                ]]);
        }

        return $this->redirectToSteam();
    }

    /**
     * Get the user by steam_id or return null
     *
     * @param $info
     * @return User|null
     */
    protected function findUserOrNull($info): ?User
    {
        return User::where('steam_id', $info->steamID64)->first();
    }
}
