<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Core\Workflow\Contracts\WorkflowContextInterface;

use App\Core\Workflow\AbstractWorkflow;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Modules\Subscription\Application\Actions\ActivateSubscriptionAction;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Core\ActionBus\ActionDispatcher;

final class ActivateWorkflow extends AbstractWorkflow
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

        /** @var Subscription */
        return $this->dispatcher->dispatch(
            ActivateSubscriptionAction::class,
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
            new SubscriptionActivated(
                $subscription
            )
        );
    }

}
