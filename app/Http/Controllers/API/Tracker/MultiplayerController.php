<?php

namespace App\Http\Controllers\API\Tracker;

use App\Actions\Game\GetNearestCity;
use App\Actions\Multiplayer\FindPlayer;
use App\Actions\Multiplayer\FindServer;
use App\Http\Controllers\Controller;
use App\Http\Resources\Multiplayer\PlayerResource;
use App\Http\Resources\Multiplayer\ServerResource;
use Illuminate\Http\Request;

class MultiplayerController extends Controller
{
    public function resolveTruckersmpPlayerData(
        Request        $request,
        FindPlayer     $findPlayer,
        FindServer     $findServer,
        GetNearestCity $getNearestCity
    )
    {
        $user = $request->user();

        // Player info
        $playerInfo = $findPlayer->execute($user->truckersmp_id);

        if (!$playerInfo) {
            return response()->json([
                'error' => true,
                'message' => 'Player not found on TruckersMP.',
            ]);
        }

        // Server details
        $serverDetails = $findServer->execute($playerInfo['ServerId']);

        // Location details
        $location = $getNearestCity->execute($playerInfo['X'], $playerInfo['Y'], $serverDetails['game'], $serverDetails['promods']);

        return PlayerResource::make($playerInfo)
            ->additional([
                'near' => $location,
                'server' => ServerResource::make($serverDetails),
                'error' => false,
            ]);
    }
}
