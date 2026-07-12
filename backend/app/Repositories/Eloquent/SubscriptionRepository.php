<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function paginate(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator {

        return $this->query($filters)
            ->latest('id')
            ->paginate($perPage);
    }

    public function find(
        int $id
    ): ?Subscription {

        return Subscription::query()
            ->with([
                'tenant',
                'customer',
                'package',
                'invoices',
                'payments',
            ])
            ->find($id);
    }

    public function findOrFail(
        int $id
    ): Subscription {

        return Subscription::query()
            ->with([
                'tenant',
                'customer',
                'package',
                'invoices',
                'payments',
            ])
            ->findOrFail($id);
    }

    public function byCustomer(
        int $customerId
    ): Collection {

        return Subscription::query()
            ->where('customer_id', $customerId)
            ->latest('id')
            ->get();
    }

    public function byStatus(
        SubscriptionStatus $status
    ): Collection {

        return Subscription::query()
            ->where('status', $status)
            ->latest('id')
            ->get();
    }

    public function active(): Collection
    {
        return $this->byStatus(
            SubscriptionStatus::ACTIVE
        );
    }

    public function expired(): Collection
    {
        return Subscription::query()
            ->where(function (Builder $query) {

                $query
                    ->where('status', SubscriptionStatus::EXPIRED)
                    ->orWhere(function (Builder $query) {

                        $query
                            ->where('status', SubscriptionStatus::ACTIVE)
                            ->whereDate('end_date', '<', now());
                    });
            })
            ->latest('id')
            ->get();
    }

    public function create(
        array $attributes
    ): Subscription {

        return Subscription::create($attributes);
    }

    public function save(
        Subscription $subscription
    ): Subscription {

        $subscription->save();

        return $subscription->refresh();
    }

    public function update(
        Subscription $subscription,
        array $attributes
    ): Subscription {

        $subscription->fill($attributes);

        return $this->save($subscription);
    }

    public function delete(
        Subscription $subscription
    ): bool {

        return (bool) $subscription->delete();
    }

    /**
     * -------------------------------------------------------------
     * Internal Query Builder
     * -------------------------------------------------------------
     */
    private function query(
        array $filters = []
    ): Builder {

        $query = Subscription::query()
            ->with([
                'customer',
                'package',
            ]);

        if (isset($filters['status'])) {

            $query->where(
                'status',
                $filters['status']
            );
        }

        if (isset($filters['customer_id'])) {

            $query->where(
                'customer_id',
                $filters['customer_id']
            );
        }

        if (! empty($filters['search'])) {

            $search = $filters['search'];

            $query->whereHas(
                'customer',
                function (Builder $builder) use ($search) {

                    $builder
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                }
            );
        }

        return $query;
    }
}
