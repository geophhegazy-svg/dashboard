<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Contracts;

interface WalletServiceInterface
{
    public function credit(
        int $tenantId,
        int $customerId,
        float $amount,
        string $description,
        ?string $reference = null,
    ): void;
}
