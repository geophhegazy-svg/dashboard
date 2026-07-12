<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\Domain\Shared\Contracts\ActionInterface;
use App\Contracts\MikrotikServiceInterface;
use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Events\SubscriptionRestored;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class RestoreSubscriptionAction implements ActionInterface
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    /**
     * Restore subscription.
     */
    public function execute(
        mixed ...$arguments
    ): Subscription {
        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        DB::transaction(function () use ($subscription): void {

            /*
            |--------------------------------------------------------------------------
            | Restore Subscription State
            |--------------------------------------------------------------------------
            */
            $subscription->restore();

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
            SubscriptionRestored::dispatch($subscription);
        });

        return $subscription->fresh();
    }
}
