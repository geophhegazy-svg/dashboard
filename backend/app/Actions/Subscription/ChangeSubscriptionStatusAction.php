<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Contracts\Domain\Shared\Contracts\ActionInterface;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;

class ChangeSubscriptionStatusAction implements ActionInterface
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
    ) {}

    public function execute(
        mixed ...$arguments
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        /** @var SubscriptionStatus $targetStatus */
        $targetStatus = $arguments[1];

        $subscription->transitionTo($targetStatus);

        return $this->subscriptions->save($subscription);
    }
}
