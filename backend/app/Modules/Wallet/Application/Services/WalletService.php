<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Services;

use App\Modules\Wallet\Application\Actions\DepositWalletAction;
use App\Modules\Wallet\Application\Contracts\WalletServiceInterface;
use App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface;
use App\Modules\Wallet\Infrastructure\Persistence\Models\Wallet;

final readonly class WalletService implements WalletServiceInterface
{
    public function __construct(
        private WalletRepositoryInterface $repository,
        private DepositWalletAction $depositWallet,
    ) {}

    public function credit(
        int $tenantId,
        int $customerId,
        float $amount,
        string $description,
        ?string $reference = null,
    ): void {
        $wallet = $this->repository->findByCustomerId(
            tenantId: $tenantId,
            customerId: $customerId,
        );

        if ($wallet === null) {
            $wallet = $this->repository->create([
                'tenant_id' => $tenantId,
                'customer_id' => $customerId,
                'balance' => 0,
            ]);
        }

        $this->depositWallet->execute(
            wallet: $wallet,
            amount: $amount,
            description: $description,
            reference: $reference,
        );
    }
}
