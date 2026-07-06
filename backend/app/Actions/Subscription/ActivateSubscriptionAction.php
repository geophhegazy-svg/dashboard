<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Events\SubscriptionActivated;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class ActivateSubscriptionAction
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
            $subscription->activate();
            $subscription->save();

            /*
            |--------------------------------------------------------------------------
            | Enable PPPoE on MikroTik
            |--------------------------------------------------------------------------
            */
            if (! empty($subscription->pppoe_username)) {
                $this->mikrotikService->enablePppoe(
                    $subscription->pppoe_username
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Dispatch Domain Event
            |--------------------------------------------------------------------------
            */
            SubscriptionActivated::dispatch($subscription);

            return true;
        });
    }
}
