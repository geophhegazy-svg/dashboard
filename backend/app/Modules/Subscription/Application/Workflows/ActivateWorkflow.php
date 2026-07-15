<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Application\Shared\Workflow\AbstractWorkflow;
use App\Modules\Subscription\Application\Commands\ActivateSubscriptionAction;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Rules\CanActivateSubscriptionRule;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

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

        return $this->action->execute(
            $subscription
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
