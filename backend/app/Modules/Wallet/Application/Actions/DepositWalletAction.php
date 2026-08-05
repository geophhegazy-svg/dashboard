<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Actions;

use App\Modules\Wallet\Infrastructure\Persistence\Models\WalletTransaction;
use App\Modules\Activity\Application\Workflows\LogActivityWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final readonly class DepositWalletAction
{
    public function __construct(
        private WalletRepositoryInterface $repository,
        private readonly LogActivityWorkflow $logActivity,
    ) {}

    public function execute(
        Subscription $subscription,
        float $amount,
        string $description,
        ?string $reference = null,
    ): void {

        if ($amount <= 0) {
            throw new InvalidArgumentException(
                'Amount must be greater than zero.'
            );
        }

        $subscription = DB::transaction(function () use (
            $subscription,
            $amount,
            $description,
            $reference,
        ) {

            $subscription = $this->repository->lockSubscription(
                $subscription->id,
            );

            $before = $subscription->wallet_balance;

            $after = $before + $amount;

            $this->repository->updateBalance(
                $subscription,
                $after,
            );

            $this->repository->createTransaction([
                'tenant_id'      => $subscription->tenant_id,
                'customer_id'    => $subscription->customer_id,
                'amount'         => $amount,
                'balance_before' => $before,
                'balance_after'  => $after,
                'type'           => 'deposit',
                'reference'      => $reference,
                'description'    => $description,
            ]);

            return $subscription;
        });

        DB::afterCommit(function () use (
            $subscription,
            $description,
        ) {

            $this->logActivity->execute(
                [
                    'tenant_id' => $subscription->tenant_id,
                    'module'    => 'wallet',
                    'action'    => 'deposit', // أو deduct
                ],
                [
                    'user_id'     => null,
                    'description' => $description,
                    'ip_address'  => request()->ip(),
                ],
            );
        });
    }
}
