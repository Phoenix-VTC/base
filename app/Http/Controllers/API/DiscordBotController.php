<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Dingo\Api\Http\Response;
use Dingo\Blueprint\Annotation\Method\Get;
use Dingo\Blueprint\Annotation\Parameters;
use Dingo\Blueprint\Annotation\Resource;
use Dingo\Blueprint\Annotation\Versions;

/**
 * Actions used by the PhoenixBot on Discord.
 *
 * @Resource("Discord Bot", uri="/discord-bot")
 */
class DiscordBotController extends ApiController
{
    /**
     * Find a User by Discord ID
     *
     * Get a JSON representation of the user if found.
     *
     * @Get("/users/{discordId}")
     * @Versions({"v1"})
     * @Response(200, body={"id": 1, "username": "foo", "truckersmp_id": 1234567, "steam_id": 12345678912345678, "discord_nickname": "Wumpus", "created_at": "2021-05-17T18:13:07.000000Z", "wallet_balance": 5000000, "event_xp": 5000, "profile_picture": "https://eu.ui-avatars.com/api/?name=Wumpus", "profile_link": "https://base.phoenixvtc.com"})
     * @Parameters({
     *     @Parameter("discordId", type="integer", required=true, description="The Discord ID of the user.")
     * })
     */
    public function findUserByDiscordId($discordId): Response
    {
        $user = User::select(['id', 'username', 'steam_id', 'truckersmp_id', 'discord->nickname as discord_nickname', 'created_at'])
            ->whereJsonContains('discord->id', $discordId)
            ->firstOrFail();

        $user = array_merge($user->toArray(), [
            'wallet_balance' => $user->getWallet('default')->balance ?? 0,
            'event_xp' => $user->getWallet('event-xp')->balance ?? 0,
            'profile_picture' => $user->profile_picture,
            'profile_link' => route('users.profile', $user->id)
        ]);

        return $this->response->array($user);
    }
}
