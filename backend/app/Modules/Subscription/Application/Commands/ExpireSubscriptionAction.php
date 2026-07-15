<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Commands;

use App\Core\Contracts\ActionInterface;
use App\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionExpired;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Support\Facades\DB;

class ExpireSubscriptionAction implements ActionInterface
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    /**
     * Expire subscription.
     */
    public function execute(
        mixed ...$arguments
    ): Subscription {
        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        DB::transaction(function () use ($subscription): void {

            /*
            |--------------------------------------------------------------------------
            | Change Subscription State
            |--------------------------------------------------------------------------
            */
            $subscription->expire();

            $this->subscriptions->save($subscription);

            /*
            |--------------------------------------------------------------------------
            | Disable PPPoE User
            |--------------------------------------------------------------------------
            */
            if (! empty($subscription->pppoe_username)) {
                $this->mikrotikService->disableUser(
                    $subscription->pppoe_username
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Dispatch Domain Event
            |--------------------------------------------------------------------------
            */
            SubscriptionExpired::dispatch($subscription);
        });

        return $subscription->fresh();
    }
}
