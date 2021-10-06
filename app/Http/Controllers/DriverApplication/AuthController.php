<?php

namespace App\Http\Controllers\DriverApplication;

use App\Http\Controllers\Controller;
use App\Rules\NotInBlocklist;
use App\Rules\Steam\HasGame;
use App\Rules\Steam\MinHours;
use App\Rules\TMP\AccountExists;
use App\Rules\TMP\BanHistoryPublic;
use App\Rules\TMP\NoRecentBans;
use App\Rules\TMP\NotInVTC;
use App\Rules\TMP\UniqueInApplications;
use App\Rules\TMP\UniqueInUsers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Invisnik\LaravelSteamAuth\SteamAuth;
use JsonException;

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
     * @throws JsonException
     */
    public function handle(Request $request): RedirectResponse
    {
        try {
            if ($this->steam->validate()) {
                $info = $this->steam->getUserInfo();

                if (!is_null($info)) {
                    $validator = Validator::make($info->toArray(), [
                        'steamID64' => [
                            'bail',
                            new NotInBlocklist,
                            new HasGame,
                            new MinHours,
                            new AccountExists,
                            new BanHistoryPublic,
                            new NoRecentBans,
                            new NotInVTC,
                            new UniqueInUsers,
                            new UniqueInApplications
                        ],
                        'personaname' => [
                            new NotInBlocklist,
                        ],
                        'realname' => [
                            'nullable',
                            new NotInBlocklist,
                        ]
                    ]);

                    if ($validator->fails()) {
                        return redirect(route('driver-application.authenticate'))
                            ->withErrors($validator)
                            ->withInput();
                    }

                    try {
                        $this->storeTruckersMPAccount($info->toArray()['steamID64']);
                    } catch (GuzzleException $e) {
                        return redirect(route('driver-application.authenticate'))
                            ->withErrors([
                                'TruckersMP API Error' => 'We couldn\'t contact the TruckersMP API, please try again. If this keeps happening, visit <a class="font-semibold" href="https://truckersmpstatus.com/">TruckersMPStatus.com</a>.'
                            ])
                            ->withInput();
                    }

                    $request->session()->put('steam_user', $info);

                    return redirect(route('driver-application.apply'));
                }
            }
        } catch (GuzzleException $e) {
            return redirect(route('driver-application.authenticate'))
                ->withErrors([
                    'TruckersMP API Error' => 'We couldn\'t contact the Steam or TruckersMP API, please try again. If this keeps happening, visit <a class="font-semibold" href="https://truckersmpstatus.com/">TruckersMPStatus.com</a>.'
                ])
                ->withInput();
        }

        return $this->redirectToSteam();
    }

    /**
     * @throws GuzzleException|JsonException
     */
    public function storeTruckersMPAccount($steamId): void
    {
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
