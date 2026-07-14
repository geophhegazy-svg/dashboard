<?php

declare(strict_types=1);

namespace App\Application\Subscription\Workflows;

use App\Actions\Subscription\SuspendSubscriptionAction;
use App\Application\Shared\Contracts\WorkflowInterface;
use App\Application\Subscription\Validators\ActivateSubscriptionValidator;
use App\Modules\Subscription\Domain\Events\SubscriptionSuspended;
use App\Models\Subscription;
use App\Services\Subscription\SubscriptionRulesService;
use Illuminate\Support\Facades\DB;

class SuspendSubscriptionWorkflow implements WorkflowInterface
{
    public function __construct(
        private readonly ActivateSubscriptionValidator $validator,
        private readonly SubscriptionRulesService $rules,
        private readonly SuspendSubscriptionAction $action,
    ) {}

    public function handle(
        mixed ...$arguments
    ): Subscription {

        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $this->validator->validate($subscription);

        /*
        |--------------------------------------------------------------------------
        | Business Rules
        |--------------------------------------------------------------------------
        */

        $this->rules->ensureCanSuspend($subscription);

        /*
        |--------------------------------------------------------------------------
        | Execute
        |--------------------------------------------------------------------------
        */

        $subscription = DB::transaction(
            fn() => $this->action->execute($subscription)
        );

        /*
        |--------------------------------------------------------------------------
        | Domain Event
        |--------------------------------------------------------------------------
        */

        SubscriptionSuspended::dispatch($subscription);

        return $subscription;
    }
}
