<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Core\ActionBus\ActionDispatcher;
use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Modules\Subscription\Application\Actions\RestoreSubscriptionAction;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class RestoreWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly ActionDispatcher $dispatcher,
        private readonly EventDispatcherInterface $events,
    ) {}

    protected function perform(
        WorkflowContextInterface $context,
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $context->dto()[0] ?? null;

        return $this->dispatcher->dispatch(
            RestoreSubscriptionAction::class,
            $subscription,
        );
    }

    protected function after(
        mixed $result,
        WorkflowContextInterface $context,
    ): void {

        /** @var Subscription $subscription */
        $subscription = $result;

        $this->events->dispatch(
            new SubscriptionRestored(
                $subscription
            )
        );
    }
}
