<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Application\Shared\Workflow\AbstractWorkflow;
use App\Modules\Subscription\Application\Actions\ActivateSubscriptionAction;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Rules\CanActivateSubscriptionRule;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Core\ActionBus\ActionDispatcher;
use App\Core\ActionBus\ActionRegistry;

final class ActivateWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly ActivateSubscriptionAction $action,
    ) {}



    protected function perform(
        mixed ...$arguments
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        $registry = app(ActionRegistry::class);

        if (! $registry->has(
            ActivateSubscriptionAction::class
        )) {
            $registry->register(
                ActivateSubscriptionAction::class
            );
        }

        /** @var Subscription */
        return app(ActionDispatcher::class)
            ->dispatch(
                ActivateSubscriptionAction::class,
                $subscription,
            );
    }



    protected function after(
        mixed $result,
        mixed ...$arguments
    ): void {

        /** @var Subscription $subscription */
        $subscription = $result;

        SubscriptionActivated::dispatch(
            $subscription
        );
    }



    protected function rules(): iterable
    {
        return [
            new CanActivateSubscriptionRule(),
        ];
    }
}
