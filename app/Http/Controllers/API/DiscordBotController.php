<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * Actions used by the PhoenixBot on Discord.
 *
 * @Resource("Discord Bot", uri="/discord-bot")
 */
class DiscordBotController extends Controller
{
    /**
     * Find a User by Discord ID
     *
     * Get a JSON representation of the user if found.
     */
    public function findUserByDiscordId($discordId): JsonResponse
    {
        $user = User::select(['id', 'username', 'steam_id', 'truckersmp_id', 'discord->nickname as discord_nickname', 'profile_picture_path', 'created_at'])
            ->whereJsonContains('discord->id', $discordId)
            ->firstOrFail();

        $user = array_merge($user->toArray(), [
            'wallet_balance' => $user->getWallet('default')->balance ?? 0,
            'event_xp' => $user->getWallet('event-xp')->balance ?? 0,
            'job_xp' => $user->getWallet('job-xp')->balance ?? 0,
            'driver_points' => $user->totalDriverPoints(),
            'profile_picture' => $user->profile_picture,
            'profile_link' => route('users.profile', $user->username)
        ]);

        return response()->json($user);
    }
}
