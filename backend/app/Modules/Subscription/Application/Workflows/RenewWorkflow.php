<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Core\Workflow\AbstractWorkflow;
use App\Modules\Subscription\Application\Actions\RenewSubscriptionAction;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class RenewWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly RenewSubscriptionAction $action,
    ) {}

    protected function perform(
        mixed ...$arguments
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        $days = $arguments[1] ?? 30;

        return $this->action->execute(
            $subscription,
            $days
        );
    }
}
