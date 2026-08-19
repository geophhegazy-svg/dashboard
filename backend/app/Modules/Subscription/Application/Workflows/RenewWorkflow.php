<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Core\ActionBus\ActionDispatcher;
use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Modules\Subscription\Application\Actions\RenewSubscriptionAction;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Support\Str;

final class RenewWorkflow extends AbstractWorkflow
{
    private string $renewalKey;
    public function __construct(
        private readonly ActionDispatcher $dispatcher,
        private readonly EventDispatcherInterface $events,
    ) {}

    protected function perform(
        WorkflowContextInterface $context,
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $context->dto()[0] ?? null;

        $days = (int) ($context->dto()[1] ?? 30);

        $renewalKey = Str::uuid()->toString();

        $result = $this->dispatcher->dispatch(
            RenewSubscriptionAction::class,
            $subscription,
            $days,
        );

        $this->renewalKey = $renewalKey;

        return $result;
    }

    protected function after(
        mixed $result,
        WorkflowContextInterface $context,
    ): void {

        /** @var Subscription $subscription */
        $subscription = $result;

        $this->events->dispatch(
            new SubscriptionRenewed(
                $subscription,
                $this->renewalKey,
            )
        );
    }
}
