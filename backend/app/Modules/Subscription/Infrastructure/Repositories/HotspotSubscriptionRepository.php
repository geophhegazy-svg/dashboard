<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Infrastructure\Repositories;

use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use Illuminate\Pagination\LengthAwarePaginator;

final class HotspotSubscriptionRepository implements HotspotSubscriptionRepositoryInterface
{
    public function paginate(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator {

        $query = HotspotSubscription::query()
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

        return $query
            ->latest()
            ->paginate($perPage);
    }

    public function find(
        int $id
    ): ?HotspotSubscription {

        return HotspotSubscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->find($id);
    }

    public function findOrFail(
        int $id
    ): HotspotSubscription {

        return HotspotSubscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->findOrFail($id);
    }

    public function create(
        array $attributes
    ): HotspotSubscription {

        return HotspotSubscription::create(
            $attributes
        );
    }

    public function update(
        HotspotSubscription $subscription,
        array $attributes
    ): HotspotSubscription {

        $subscription->fill($attributes);

        return $this->save($subscription);
    }

    public function save(
        HotspotSubscription $subscription
    ): HotspotSubscription {

        $subscription->save();

        return $subscription->fresh([
            'customer',
            'package',
        ]);
    }

    public function delete(
        HotspotSubscription $subscription
    ): bool {

        return (bool) $subscription->delete();
    }
}
