<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\Domain\Shared\Contracts\ActionInterface;
use App\Contracts\MikrotikServiceInterface;
use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Events\SubscriptionRenewed;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class RenewSubscriptionAction implements ActionInterface
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    /**
     * Renew subscription.
     */
    public function execute(
        mixed ...$arguments
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        $days = (int) ($arguments[1] ?? 30);

        DB::transaction(function () use ($subscription, $days): void {

            /*
            |--------------------------------------------------------------------------
            | Domain State Transition
            |--------------------------------------------------------------------------
            */
            $subscription->renew($days);

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
            SubscriptionRenewed::dispatch(
                $subscription
            );
        });

        return $subscription->fresh();
    }
}
