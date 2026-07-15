<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Application\Shared\Workflow\AbstractWorkflow;
use App\Modules\Subscription\Application\Commands\RestoreSubscriptionAction;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class RestoreWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly RestoreSubscriptionAction $action,
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
}
