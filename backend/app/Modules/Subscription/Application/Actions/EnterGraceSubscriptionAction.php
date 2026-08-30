<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Core\Contracts\ActionInterface;
use App\Modules\Billing\Domain\Contracts\BillingCycleServiceInterface;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class EnterGraceSubscriptionAction implements ActionInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptions,
        private BillingCycleServiceInterface $billingCycle,
    ) {}

    public function execute(
        mixed ...$arguments
    ): Subscription {
        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        $billingDate = $subscription->end_date->copy();

        $subscription->enterGrace();

        $subscription->grace_start_date = now()->toDateString();

        $subscription->grace_end_date = $this->billingCycle
            ->calculateGraceDate(
                $billingDate,
                $subscription->package->grace_days,
            )
            ->toDateString();

        $this->subscriptions->save($subscription);

        return $subscription->fresh();
    }
}
