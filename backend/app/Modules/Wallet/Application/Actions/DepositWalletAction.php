<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface;
use App\Modules\Wallet\Infrastructure\Persistence\Models\Wallet;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final readonly class DepositWalletAction
{
    public function __construct(
        private WalletRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(
        Wallet $wallet,
        float $amount,
        string $description,
        ?string $reference = null,
    ): void {
        if ($amount <= 0) {
            throw new InvalidArgumentException(
                'Amount must be greater than zero.'
            );
        }

        $wallet = DB::transaction(function () use (
            $wallet,
            $amount,
            $description,
            $reference,
        ): Wallet {
            $wallet = $this->repository->lock($wallet);

            $before = (float) $wallet->balance;
            $after = $before + $amount;

            $this->repository->updateBalance(
                $wallet,
                $after,
            );

            $this->repository->createTransaction([
                'tenant_id' => $wallet->tenant_id,
                'customer_id' => $wallet->customer_id,
                'amount' => $amount,
                'balance_before' => $before,
                'balance_after' => $after,
                'type' => 'deposit',
                'reference' => $reference,
                'description' => $description,
            ]);

            return $wallet->refresh();
        });

        DB::afterCommit(function () use (
            $wallet,
            $description,
        ): void {
            $this->logActivity->execute(
                [
                    'tenant_id' => $wallet->tenant_id,
                    'module' => 'wallet',
                    'action' => 'deposit',
                ],
                [
                    'user_id' => null,
                    'description' => $description,
                    'ip_address' => request()->ip(),
                ],
            );
        });
    }
}
