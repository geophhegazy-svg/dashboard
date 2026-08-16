<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Services;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Wallet\Application\Actions\DepositWalletAction;
use App\Modules\Wallet\Application\Contracts\WalletServiceInterface;

final readonly class WalletService implements WalletServiceInterface
{
    public function __construct(
        private DepositWalletAction $depositWallet,
    ) {}

    public function credit(
        Subscription $subscription,
        float $amount,
        string $description,
        ?string $reference = null,
    ): void {
        $this->depositWallet->execute(
            subscription: $subscription,
            amount: $amount,
            description: $description,
            reference: $reference,
        );
    }
}
