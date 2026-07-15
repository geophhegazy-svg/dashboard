<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Application\Shared\Workflow\AbstractWorkflow;
use App\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Application\Commands\ExpireSubscriptionAction;
use App\Modules\Subscription\Domain\Events\SubscriptionExpired;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class ExpireWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly ExpireSubscriptionAction $action,
        private readonly MikrotikServiceInterface $mikrotik,
    ) {}

    protected function perform(
        mixed ...$arguments
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        return $this->action->execute(
            $subscription
        );
    }

    protected function after(
        mixed $result,
        mixed ...$arguments
    ): void {

        /** @var Subscription $subscription */
        $subscription = $result;

        if (! empty($subscription->pppoe_username)) {

            $this->mikrotik->disableUser(
                $subscription->pppoe_username
            );
        }

        SubscriptionExpired::dispatch(
            $subscription
        );
    }
}
