<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Subscription;

interface WalletRepositoryInterface
{
    public function lockSubscription(int $id): Subscription;

    public function updateBalance(
        Subscription $subscription,
        float $balance
    ): bool;
}
