<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Orchestrators;

use App\Core\Workflow\WorkflowEngine;
use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Support\Facades\Log;

final readonly class AutoRenewSubscriptionsOrchestrator
    implements AutoRenewSubscriptionsOrchestratorInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptions,
        private WorkflowEngine $engine,
        private RenewWorkflow $renewWorkflow,
    ) {}

    public function execute(): int
    {
        $subscriptions = $this->subscriptions
            ->findEligibleForAutoRenew();

        $count = 0;

        foreach ($subscriptions as $subscription) {
            $this->engine->run(
                $this->renewWorkflow,
                $subscription,
            );

            $count++;
        }

        Log::info(
            'Subscriptions auto renewed.',
            [
                'count' => $count,
            ],
        );

        return $count;
    }
}
