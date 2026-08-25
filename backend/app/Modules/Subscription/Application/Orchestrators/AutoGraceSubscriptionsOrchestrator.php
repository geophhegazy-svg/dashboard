<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Orchestrators;

use App\Core\Workflow\WorkflowEngine;
use App\Modules\Subscription\Application\Workflows\EnterGraceWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Support\Facades\Log;

final readonly class AutoGraceSubscriptionsOrchestrator implements AutoGraceSubscriptionsOrchestratorInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptions,
        private WorkflowEngine $engine,
        private EnterGraceWorkflow $enterGraceWorkflow,
    ) {}

    public function execute(): int
    {
        $subscriptions = $this->subscriptions
            ->findEligibleForGracePeriod();

        $count = 0;

        foreach ($subscriptions as $subscription) {
            $this->engine->run(
                $this->enterGraceWorkflow,
                $subscription,
            );

            $count++;
        }

        Log::info(
            'Subscriptions auto entered grace period.',
            [
                'count' => $count,
            ],
        );

        return $count;
    }
}
