<?php

namespace App\Rules\Steam;

use Illuminate\Contracts\Validation\Rule;
use Syntax\SteamApi\Client as SteamClient;

class MinHours implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $steamClient = new SteamClient();

        $playtime = $steamClient->player($value)
            ->GetOwnedGames()
            ->filter(function ($value) {
                return
                    $value->appId === 227300 || // ETS2
                    $value->appId === 270880 // ATS
;
            })
            ->pluck('playtimeForever') // Playtime in minutes
            ->sum();

        return $playtime >= 4500; // 4500 minutes = 75 hours
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '
            It looks like you do not have at least 75 in-game hours on Euro Truck Simulator 2 <strong>and/or</strong> American Truck Simulator.
            <br>
            Please make sure that you are using the correct Steam account.
            <br>
            If you think that this is an error, please make sure that your profile is set to public here:
            <a class="prose" target="_blank" href="https://support.steampowered.com/kb_article.php?ref=4113-YUDH-6401">https://support.steampowered.com/kb_article.php?ref=4113-YUDH-6401</a>
        ';
    }
}
