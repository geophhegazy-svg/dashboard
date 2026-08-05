<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Domain\Contracts;

use App\Modules\Wallet\Infrastructure\Persistence\Models\WalletTransaction;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface WalletRepositoryInterface
{
    public function lockSubscription(int $id): Subscription;

    public function updateBalance(
        Subscription $subscription,
        float $balance
    ): bool;

    public function createTransaction(
        array $data
    ): WalletTransaction;
}
