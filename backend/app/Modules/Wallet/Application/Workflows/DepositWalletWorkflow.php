<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Workflows;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Wallet\Application\Actions\DepositWalletAction;

final readonly class DepositWalletWorkflow
{
    public function __construct(
        private DepositWalletAction $depositWallet,
    ) {}

    public function execute(
        Subscription $subscription,
        float $amount,
        string $description,
        ?string $reference = null,
    ): void {

        $this->depositWallet->execute(
            $subscription,
            $amount,
            $description,
            $reference,
        );
    }
}
