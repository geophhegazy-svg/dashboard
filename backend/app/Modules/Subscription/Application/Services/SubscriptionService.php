<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Services;

use App\Core\Workflow\WorkflowEngine;

use App\Modules\Subscription\Application\Workflows\ActivateWorkflow;
use App\Modules\Subscription\Application\Workflows\ExpireWorkflow;
use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Application\Workflows\RestoreWorkflow;
use App\Modules\Subscription\Application\Workflows\SuspendWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class SubscriptionService
{
    public function __construct(
        private readonly WorkflowEngine $engine,
        private readonly ActivateWorkflow $activateWorkflow,
        private readonly SuspendWorkflow $suspendWorkflow,
        private readonly ExpireWorkflow $expireWorkflow,
        private readonly RestoreWorkflow $restoreWorkflow,
        private readonly RenewWorkflow $renewWorkflow,
    ) {
    }

    public function activate(
        Subscription $subscription
    ): Subscription {

        $result = $this->engine->run(
            $this->activateWorkflow,
            $subscription,
        );

        /** @var Subscription $activated */
        $activated = $result->payload();

        return $activated;
    }

    public function suspend(
        Subscription $subscription
    ): Subscription {

        $result = $this->engine->run(
            $this->suspendWorkflow,
            $subscription,
        );

        /** @var Subscription $suspended */
        $suspended = $result->payload();

        return $suspended;
    }

    public function expire(
        Subscription $subscription
    ): Subscription {

        $result = $this->engine->run(
            $this->expireWorkflow,
            $subscription,
        );

        /** @var Subscription $expired */
        $expired = $result->payload();

        return $expired;
    }

    public function restore(
        Subscription $subscription
    ): Subscription {

        $result = $this->engine->run(
            $this->restoreWorkflow,
            $subscription,
        );

        /** @var Subscription $restored */
        $restored = $result->payload();

        return $restored;
    }

    public function renew(
        Subscription $subscription,
        int $days = 30
    ): Subscription {

        $result = $this->engine->run(
            $this->renewWorkflow,
            $subscription,
            $days,
        );

        /** @var Subscription $renewed */
        $renewed = $result->payload();

        return $renewed;
    }

}
