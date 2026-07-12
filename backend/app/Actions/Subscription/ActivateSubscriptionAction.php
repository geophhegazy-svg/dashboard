<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\Domain\Shared\Contracts\ActionInterface;
use App\Contracts\MikrotikServiceInterface;
use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Events\SubscriptionActivated;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class ActivateSubscriptionAction implements ActionInterface
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    /**
     * Activate subscription.
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
            $subscription->activate();

            $this->subscriptions->save($subscription);

            /*
            |--------------------------------------------------------------------------
            | Enable PPPoE User
            |--------------------------------------------------------------------------
            */
            if (! empty($subscription->pppoe_username)) {
                $this->mikrotikService->enableUser(
                    $subscription->pppoe_username
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Dispatch Domain Event
            |--------------------------------------------------------------------------
            */
            SubscriptionActivated::dispatch($subscription);
        });

        return $subscription->fresh();
    }
}
