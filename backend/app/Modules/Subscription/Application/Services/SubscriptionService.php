<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Services;

use App\Core\Workflow\WorkflowEngine;

use App\Modules\Subscription\Application\Actions\CreateSubscriptionAction;
use App\Modules\Subscription\Application\Workflows\ActivateWorkflow;
use App\Modules\Subscription\Application\Workflows\ExpireWorkflow;
use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Application\Workflows\RestoreWorkflow;
use App\Modules\Subscription\Application\Workflows\SuspendWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly CreateSubscriptionAction $createSubscriptionAction,
        private readonly WorkflowEngine $engine,
        private readonly ActivateWorkflow $activateWorkflow,
        private readonly SuspendWorkflow $suspendWorkflow,
        private readonly ExpireWorkflow $expireWorkflow,
        private readonly RestoreWorkflow $restoreWorkflow,
        private readonly RenewWorkflow $renewWorkflow,
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    public function paginate(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->subscriptions->paginate(
            $filters,
            $perPage
        );
    }

    public function find(
        int $id
    ): ?Subscription {
        return $this->subscriptions->find($id);
    }

    public function findOrFail(
        int $id
    ): Subscription {
        return $this->subscriptions->findOrFail($id);
    }

    public function byCustomer(
        int $customerId
    ): Collection {
        return $this->subscriptions->byCustomer(
            $customerId
        );
    }

    public function active(): Collection
    {
        return $this->subscriptions->active();
    }

    public function expired(): Collection
    {
        return $this->subscriptions->expired();
    }

    public function byStatus(
        SubscriptionStatus $status
    ): Collection {
        return $this->subscriptions->byStatus(
            $status
        );
    }

    public function search(
        string $search,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->subscriptions->paginate(
            [
                'search' => $search,
            ],
            $perPage
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Commands
    |--------------------------------------------------------------------------
    */

    public function create(
        array $attributes
    ): Subscription {

        return DB::transaction(function () use ($attributes): Subscription {

            $subscription = $this->createSubscriptionAction->execute(
                $attributes
            );

            Log::info(
                'Subscription created.',
                [
                    'subscription_id' => $subscription->id,
                ]
            );

            return $subscription;
        });
    }

    public function update(
        Subscription $subscription,
        array $attributes
    ): Subscription {

        return $this->subscriptions->update(
            $subscription,
            $attributes
        );
    }

    public function activate(
        Subscription $subscription
    ): Subscription {

        $result = $this->engine->run(
            $this->activateWorkflow,
            $subscription,
        );

        /** @var Subscription $activated */
        $activated = $result->payload();

        return $activated;
    }

    public function suspend(
        Subscription $subscription
    ): Subscription {

        $result = $this->engine->run(
            $this->suspendWorkflow,
            $subscription,
        );

        /** @var Subscription $suspended */
        $suspended = $result->payload();

        return $suspended;
    }

    public function expire(
        Subscription $subscription
    ): Subscription {

        $result = $this->engine->run(
            $this->expireWorkflow,
            $subscription,
        );

        /** @var Subscription $expired */
        $expired = $result->payload();

        return $expired;
    }

    public function restore(
        Subscription $subscription
    ): Subscription {

        $result = $this->engine->run(
            $this->restoreWorkflow,
            $subscription,
        );

        /** @var Subscription $restored */
        $restored = $result->payload();

        return $restored;
    }

    public function renew(
        Subscription $subscription,
        int $days = 30
    ): Subscription {

        $result = $this->engine->run(
            $this->renewWorkflow,
            $subscription,
            $days,
        );

        /** @var Subscription $renewed */
        $renewed = $result->payload();

        return $renewed;
    }

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    public function statistics(): array
    {
        $total = $this->subscriptions->count();

        $active = $this->subscriptions->countByStatus(
            SubscriptionStatus::ACTIVE
        );

        $suspended = $this->subscriptions->countByStatus(
            SubscriptionStatus::SUSPENDED
        );

        $expired = $this->subscriptions->countByStatus(
            SubscriptionStatus::EXPIRED
        );

        $cancelled = $this->subscriptions->countByStatus(
            SubscriptionStatus::CANCELLED
        );

        return [
            'total' => $total,
            'active' => $active,
            'suspended' => $suspended,
            'expired' => $expired,
            'cancelled' => $cancelled,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function expiringSoon(
        int $days = 7
    ): Collection {

        return $this->subscriptions->expiringSoon(
            $days
        );
    }
}
