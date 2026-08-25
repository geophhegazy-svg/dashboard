<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Orchestrators;

use App\Core\Workflow\WorkflowEngine;

use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Application\Workflows\ExpireWorkflow;
use Illuminate\Support\Facades\Log;

final readonly class AutoExpireSubscriptionsOrchestrator implements AutoExpireSubscriptionsOrchestratorInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptions,
        private WorkflowEngine $engine,
        private ExpireWorkflow $expireWorkflow,
    ) {}

    public function execute(): int
    {
        $subscriptions = $this->subscriptions->expiredCandidates();

        $count = 0;

        foreach ($subscriptions as $subscription) {

            $this->engine->run(
                $this->expireWorkflow,
                $subscription,
            );

            $count++;
        }

        Log::info(
            'Subscriptions auto expired.',
            [
                'count' => $count,
            ],
        );

        return $count;
    }
}
