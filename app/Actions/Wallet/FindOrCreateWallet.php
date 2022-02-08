<?php

namespace App\Actions\Wallet;

use App\Models\User;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Support\Str;

class FindOrCreateWallet
{
    /**
     * @param User $user
     * @param string $walletName
     * @return Wallet
     */
    public function execute(User $user, string $walletName): Wallet
    {
        $slug = Str::slug($walletName);

        if (! $user->hasWallet($slug)) {
            $user->createWallet([
                'name' => $walletName,
                'slug' => $slug,
            ]);
        }

        return $user->getWalletOrFail($slug);
    }
}
