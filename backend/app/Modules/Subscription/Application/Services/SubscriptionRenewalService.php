<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Services;

use App\Core\Workflow\WorkflowEngine;

use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Subscription\Application\Contracts\SubscriptionRenewalServiceInterface;

final readonly class SubscriptionRenewalService implements SubscriptionRenewalServiceInterface
{
    public function __construct(
        private WorkflowEngine $engine,
        private RenewWorkflow $workflow,
    ) {}

    public function renew(
        Subscription $subscription,
    ): bool {

        $this->engine->run(
            $this->workflow,
            $subscription,
        );

        return true;
    }
}
