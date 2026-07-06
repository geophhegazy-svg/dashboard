<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Enums\SubscriptionStatus;
use App\Events\SubscriptionRenewed;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class RenewSubscriptionAction
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    public function execute(
        Subscription $subscription,
        int $days = 30
    ): bool {
        return DB::transaction(function () use ($subscription, $days) {

            /*
            |--------------------------------------------------------------------------
            | Renew Subscription
            |--------------------------------------------------------------------------
            */
            $subscription->status = SubscriptionStatus::ACTIVE;
            $subscription->end_date = now()->addDays($days);
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
            SubscriptionRenewed::dispatch($subscription);

            return true;
        });
    }
}
