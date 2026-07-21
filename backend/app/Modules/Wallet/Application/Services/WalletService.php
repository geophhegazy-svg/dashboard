<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Services;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Models\WalletTransaction;
use App\Modules\Activity\Application\Services\ActivityLogService;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;


class WalletService
{
    public static function deposit(
        Subscription $subscription,
        float $amount,
        string $description,
        ?string $reference = null
    ): void {

        if ($amount <= 0) {
            throw new InvalidArgumentException('Amount must be greater than zero.');
        }

        $subscription = DB::transaction(function () use (
            $subscription,
            $amount,
            $description,
            $reference
        ) {

            $subscription = Subscription::query()
                ->lockForUpdate()
                ->findOrFail($subscription->id);

            $before = $subscription->wallet_balance;
            $after = $before + $amount;

            $subscription->update([
                'wallet_balance' => $after,
            ]);

            WalletTransaction::create([
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

        DB::afterCommit(function () use ($subscription, $description) {
            ActivityLogService::log(
                tenantId: $subscription->tenant_id,
                userId: null,
                module: 'wallet',
                action: 'deposit',
                description: $description
            );
        });
    }

    public static function deduct(
        Subscription $subscription,
        float $amount,
        string $description,
        ?string $reference = null
    ): void {

        if ($amount <= 0) {
            throw new InvalidArgumentException('Amount must be greater than zero.');
        }

        $subscription = DB::transaction(function () use (
            $subscription,
            $amount,
            $description,
            $reference
        ) {

            $subscription = Subscription::query()
                ->lockForUpdate()
                ->findOrFail($subscription->id);

            $before = $subscription->wallet_balance;

            if ($before < $amount) {
                throw new RuntimeException('Insufficient wallet balance.');
            }

            $after = $before - $amount;

            $subscription->update([
                'wallet_balance' => $after,
            ]);

            WalletTransaction::create([
                'tenant_id'      => $subscription->tenant_id,
                'customer_id'    => $subscription->customer_id,
                'amount'         => $amount,
                'balance_before' => $before,
                'balance_after'  => $after,
                'type'           => 'deduct',
                'reference'      => $reference,
                'description'    => $description,
            ]);

            return $subscription;
        });

        DB::afterCommit(function () use ($subscription, $description) {
            ActivityLogService::log(
                tenantId: $subscription->tenant_id,
                userId: null,
                module: 'wallet',
                action: 'deduct',
                description: $description
            );
        });
    }
}
