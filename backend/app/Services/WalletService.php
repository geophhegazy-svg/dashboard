<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\WalletTransaction;
use App\Services\ActivityLogService;

class WalletService
{
    public static function deduct(
        Subscription $subscription,
        float $amount,
        string $type,
        string $description,
        ?string $reference = null
    ) {

        $before = $subscription->wallet_balance;

        $after = $before - $amount;

        $subscription->update([
            'wallet_balance' => $after
        ]);

        WalletTransaction::create([

            'tenant_id' => $subscription->tenant_id,

            'customer_id' => $subscription->customer_id,

            'amount' => -$amount,

            'balance_before' => $before,

            'balance_after' => $after,

            'type' => $type,

            'reference' => $reference,

            'description' => $description

        ]);
        ActivityLogService::log(

            tenantId: $subscription->tenant_id,

            userId: null,

            module: 'wallet',

            action: 'deduct',

            description: $description

        );
    }

    public static function deposit(
        Subscription $subscription,
        float $amount,
        string $description,
        ?string $reference = null
    ) {

        $before = $subscription->wallet_balance;

        $after = $before + $amount;

        $subscription->update([
            'wallet_balance' => $after
        ]);

        WalletTransaction::create([

            'tenant_id' => $subscription->tenant_id,

            'customer_id' => $subscription->customer_id,

            'amount' => $amount,

            'balance_before' => $before,

            'balance_after' => $after,

            'type' => 'deposit',

            'reference' => $reference,

            'description' => $description

        ]);
        ActivityLogService::log(

            tenantId: $subscription->tenant_id,

            userId: null,

            module: 'wallet',

            action: 'deposit',

            description: $description

        );
    }
}
