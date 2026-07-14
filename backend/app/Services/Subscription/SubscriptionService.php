<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Modules\Subscription\Application\Commands\ActivateSubscriptionAction;
use App\Modules\Subscription\Application\Commands\ExpireSubscriptionAction;
use App\Modules\Subscription\Application\Commands\RenewSubscriptionAction;
use App\Modules\Subscription\Application\Commands\RestoreSubscriptionAction;
use App\Modules\Subscription\Application\Commands\SuspendSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,

        private readonly ActivateSubscriptionAction $activateAction,
        private readonly SuspendSubscriptionAction $suspendAction,
        private readonly ExpireSubscriptionAction $expireAction,
        private readonly RestoreSubscriptionAction $restoreAction,
        private readonly RenewSubscriptionAction $renewAction,
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

            $customer = Customer::findOrFail(
                $attributes['customer_id']
            );

            $package = Package::findOrFail(
                $attributes['package_id']
            );

            $duration = (int) (
                $attributes['duration_days']
                ?? ($package->duration_days ?? 30)
            );

            $subscription = $this->subscriptions->create([
                'tenant_id'         => $customer->tenant_id,
                'customer_id'       => $customer->id,
                'package_id'        => $package->id,
                'start_date'        => now(),
                'end_date'          => now()->addDays($duration),
                'monthly_price'     => $attributes['monthly_price']
                    ?? $package->price,
                'status'            => SubscriptionStatus::ACTIVE,
                'notes'             => $attributes['notes'] ?? null,
                'pppoe_username'    => $attributes['pppoe_username'] ?? null,
                'pppoe_password'    => $attributes['pppoe_password'] ?? null,
                'mikrotik_profile'  => $package->mikrotik_profile,
                'wallet_balance'    => 0,
            ]);

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

        return $this->activateAction->execute(
            $subscription
        );
    }

    public function suspend(
        Subscription $subscription
    ): Subscription {

        return $this->suspendAction->execute(
            $subscription
        );
    }

    public function expire(
        Subscription $subscription
    ): Subscription {

        return $this->expireAction->execute(
            $subscription
        );
    }

    public function restore(
        Subscription $subscription
    ): Subscription {

        return $this->restoreAction->execute(
            $subscription
        );
    }

    public function renew(
        Subscription $subscription,
        int $days = 30
    ): Subscription {

        return $this->renewAction->execute(
            $subscription,
            $days
        );
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
    | Scheduler
    |--------------------------------------------------------------------------
    */

    public function autoExpire(): int
    {
        $subscriptions = Subscription::query()
            ->where('status', SubscriptionStatus::ACTIVE)
            ->where('end_date', '<', now())
            ->get();

        $count = 0;

        foreach ($subscriptions as $subscription) {

            $this->expireAction->execute($subscription);

            $count++;
        }

        Log::info(
            'Subscriptions auto expired.',
            [
                'count' => $count,
            ]
        );

        return $count;
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
