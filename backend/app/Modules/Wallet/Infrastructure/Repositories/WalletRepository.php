<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Infrastructure\Repositories;

use App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class WalletRepository implements WalletRepositoryInterface
{
    public function lockSubscription(int $id): Subscription
    {
        return Subscription::query()
            ->lockForUpdate()
            ->findOrFail($id);
    }

    public function updateBalance(
        Subscription $subscription,
        float $balance
    ): bool {
        return $subscription->update([
            'wallet_balance' => $balance,
        ]);
    }
}
