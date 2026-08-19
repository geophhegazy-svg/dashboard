<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Services;

use App\Core\Workflow\WorkflowEngine;

use Illuminate\Support\Collection;
use App\Modules\Billing\Application\Workflows\AutomaticBillingWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Billing\Domain\Contracts\AutomaticBillingServiceInterface;

final class AutomaticBillingService
implements AutomaticBillingServiceInterface
{
    public function __construct(
        private readonly WorkflowEngine $engine,
        private readonly AutomaticBillingWorkflow $workflow,
    ) {}

    public function run(
        Collection $subscriptions,
    ): void {

        $this->engine->run(
            $this->workflow,
            $subscriptions,
        );
    }

    public function processSubscription(
        Subscription $subscription,
    ): void {

        $this->engine->run(
            $this->workflow,
            collect([$subscription]),
        );
    }
}
