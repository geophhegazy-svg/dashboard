<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Events\SubscriptionExpired;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class ExpireSubscriptionAction
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    public function execute(
        Subscription $subscription
    ): bool {

        return DB::transaction(function () use ($subscription) {

            /*
            |--------------------------------------------------------------------------
            | Change Subscription State
            |--------------------------------------------------------------------------
            */
            $subscription->expire();
            $subscription->save();

            /*
            |--------------------------------------------------------------------------
            | Disable PPPoE on MikroTik
            |--------------------------------------------------------------------------
            */
            if (! empty($subscription->pppoe_username)) {
                $this->mikrotikService->disablePppoe(
                    $subscription->pppoe_username
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Dispatch Domain Event
            |--------------------------------------------------------------------------
            */
            SubscriptionExpired::dispatch($subscription);

            return true;
        });
    }
}
