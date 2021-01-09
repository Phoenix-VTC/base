<?php

namespace App\Http\Controllers\DriverApplication;

use App\Http\Controllers\Controller;
use App\Rules\Steam\HasGame;
use App\Rules\Steam\MinHours;
use App\Rules\TMP\AccountExists;
use App\Rules\TMP\BanHistoryPublic;
use App\Rules\TMP\NoRecentBans;
use App\Rules\TMP\NotInVTC;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Invisnik\LaravelSteamAuth\SteamAuth;

class AuthController extends Controller
{
    /**
     * The SteamAuth instance.
     *
     * @var SteamAuth
     */
    protected SteamAuth $steam;

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
     * @return RedirectResponse
     */
    public function redirectToSteam(): RedirectResponse
    {
        return $this->steam->redirect();
    }

    /**
     * Get user info and log in
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function handle(Request $request): RedirectResponse
    {
        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();

            if (!is_null($info)) {
                $validator = Validator::make($info->toArray(), [
                    // Temporarily disabled the validation for testing purposes
//                    'steamID64' => ['bail', new HasGame, new MinHours, new AccountExists, new BanHistoryPublic, new NoRecentBans, new NotInVTC],
                    'steamID64' => ['bail', new HasGame, new MinHours, new AccountExists, new BanHistoryPublic],
                ]);

                if ($validator->fails()) {
                    return redirect(route('driver-application.authenticate'))
                        ->withErrors($validator)
                        ->withInput();
                }

                $this->storeTruckersMPAccount($info->toArray()['steamID64']);

                $request->session()->put('steam_user', $info);

                return redirect(route('driver-application.apply'));
            }
        }

        return $this->redirectToSteam();
    }

    public function storeTruckersMPAccount($steamId): void {
        $client = new Client();

        $response = $client->request('GET', 'https://api.truckersmp.com/v2/player/' . $steamId)->getBody();
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        session()->put('truckersmp_user', collect($response['response']));
    }

    /**
     * Redirect the user to the authentication page
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('steam_user');
        $request->session()->forget('truckersmp_user');

        return redirect()->back();
    }
}
