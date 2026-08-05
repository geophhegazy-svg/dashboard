<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Workflows;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Wallet\Application\Actions\DeductWalletAction;

final readonly class DeductWalletWorkflow
{
    public function __construct(
        private DeductWalletAction $deductWallet,
    ) {}

    public function execute(
        Subscription $subscription,
        float $amount,
        string $description,
        ?string $reference = null,
    ): void {

        $this->deductWallet->execute(
            $subscription,
            $amount,
            $description,
            $reference,
        );
    }
}
