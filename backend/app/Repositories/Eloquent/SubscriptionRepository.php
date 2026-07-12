<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function paginate(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator {

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
                function ($query) use ($search) {

                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                }
            );
        }

        return $query
            ->latest()
            ->paginate($perPage);
    }

    public function find(
        int $id
    ): ?Subscription {

        return Subscription::with([
            'customer',
            'package',
        ])->find($id);
    }

    public function findOrFail(
        int $id
    ): Subscription {

        return Subscription::with([
            'customer',
            'package',
        ])->findOrFail($id);
    }

    public function create(
        array $attributes
    ): Subscription {

        return Subscription::create(
            $attributes
        );
    }

    public function update(
        Subscription $subscription,
        array $attributes
    ): Subscription {

        $subscription->update(
            $attributes
        );

        return $subscription->fresh();
    }

    public function save(
        Subscription $subscription
    ): Subscription {

        $subscription->save();

        return $subscription->fresh();
    }

    public function delete(
        Subscription $subscription
    ): bool {

        return (bool) $subscription->delete();
    }

    public function byCustomer(
        int $customerId
    ): Collection {

        return Subscription::query()
            ->where(
                'customer_id',
                $customerId
            )
            ->latest()
            ->get();
    }

    public function byStatus(
        SubscriptionStatus $status
    ): Collection {

        return Subscription::query()
            ->where(
                'status',
                $status
            )
            ->latest()
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
        return $this->byStatus(
            SubscriptionStatus::EXPIRED
        );
    }
}
