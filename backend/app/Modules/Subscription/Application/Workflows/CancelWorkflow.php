<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Core\ActionBus\ActionDispatcher;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Modules\Subscription\Application\Actions\CancelSubscriptionAction;
use App\Modules\Subscription\Domain\Events\SubscriptionCancelled;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class CancelWorkflow extends AbstractWorkflow
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
            CancelSubscriptionAction::class,
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
            new SubscriptionCancelled(
                $subscription
            )
        );
    }
}
