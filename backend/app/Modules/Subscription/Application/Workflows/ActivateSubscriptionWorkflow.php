<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Modules\Subscription\Application\Commands\ActivateSubscriptionAction;
use App\Application\Shared\Contracts\WorkflowInterface;
use App\Application\Subscription\Validators\ActivateSubscriptionValidator;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Models\Subscription;
use App\Services\Subscription\SubscriptionRulesService;
use Illuminate\Support\Facades\DB;

class ActivateSubscriptionWorkflow implements WorkflowInterface
{
    public function __construct(
        private readonly ActivateSubscriptionValidator $validator,
        private readonly SubscriptionRulesService $rules,
        private readonly ActivateSubscriptionAction $action,
    ) {}

    public function handle(
        mixed ...$arguments
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        /*
        |--------------------------------------------------------------------------
        | Input Validation
        |--------------------------------------------------------------------------
        */

        $this->validator->validate(
            $subscription
        );

        /*
        |--------------------------------------------------------------------------
        | Business Rules
        |--------------------------------------------------------------------------
        */

        $this->rules->ensureCanActivate(
            $subscription
        );

        /*
        |--------------------------------------------------------------------------
        | Execute Use Case
        |--------------------------------------------------------------------------
        */

        $subscription = DB::transaction(
            fn() => $this->action->execute(
                $subscription
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Domain Event
        |--------------------------------------------------------------------------
        */

        SubscriptionActivated::dispatch(
            $subscription
        );

        return $subscription;
    }
}
