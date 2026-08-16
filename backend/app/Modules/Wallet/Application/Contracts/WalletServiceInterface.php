<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Contracts;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface WalletServiceInterface
{
    public function credit(
        Subscription $subscription,
        float $amount,
        string $description,
        ?string $reference = null,
    ): void;
}
