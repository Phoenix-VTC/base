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
use App\Rules\TMP\VTCHistoryPublic;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
                            new VTCHistoryPublic,
                            new UniqueInUsers,
                            new UniqueInApplications
                        ],
                        'personaname' => [
                            new NotInBlocklist,
                        ]
                    ]);

                    if ($validator->fails()) {
                        return redirect(route('driver-application.authenticate'))
                            ->withErrors($validator)
                            ->withInput();
                    }

                    // Perform a blocklist check with the TruckersMP user data
                    $tmpBlocklistCheck = $this->checkBlocklistWithTruckersmpData($info->toArray());

                    if ($tmpBlocklistCheck->fails()) {
                        return redirect(route('driver-application.authenticate'))
                            ->withErrors($tmpBlocklistCheck)
                            ->withInput();
                    }

                    // Store the TruckersMP account
                    $this->storeTruckersMPAccount($info->toArray()['steamID64']);

                    $request->session()->put('steam_user', $info);

                    return redirect(route('driver-application.apply'));
                }
            }
        } catch (GuzzleException | RequestException) {
            return redirect(route('driver-application.authenticate'))
                ->withErrors([
                    'TruckersMP API Error' => 'We couldn\'t contact the Steam or TruckersMP API, please try again. If this keeps happening, visit <a class="font-semibold" href="https://truckersmpstatus.com/">TruckersMPStatus.com</a>.'
                ])
                ->withInput();
        }

        return $this->redirectToSteam();
    }

    /**
     * @throws RequestException
     */
    public function storeTruckersMPAccount($steamId): void
    {
        $response = Http::get('https://api.truckersmp.com/v2/player/' . $steamId);

        // Throw an exception if a client or server error occurred
        $response->throw();

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

    /**
     * @throws RequestException
     */
    private function checkBlocklistWithTruckersmpData(array $steamData): \Illuminate\Validation\Validator
    {
        $response = Http::get('https://api.truckersmp.com/v2/player/' . $steamData['steamID64']);

        // Throw an exception if a client or server error occurred
        $response->throw();

        $response = $response->collect();

        return Validator::make($response['response'], [
            'id' => [
                new NotInBlocklist,
            ],
            'name' => [
                new NotInBlocklist,
            ],
            'discordSnowflake' => [
                'nullable',
                new NotInBlocklist,
            ],
        ]);
    }
}
