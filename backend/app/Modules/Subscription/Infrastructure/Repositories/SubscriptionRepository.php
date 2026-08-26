<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Infrastructure\Repositories;

use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

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

        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->find($id);
    }

    public function findOrFail(
        int $id
    ): Subscription {

        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->findOrFail($id);
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

        $subscription->fill(
            $attributes
        );

        return $this->save(
            $subscription
        );
    }

    public function save(
        Subscription $subscription
    ): Subscription {

        $ok = $subscription->save();

        return $subscription->fresh([
            'customer',
            'package',
        ]);
    }

    public function delete(
        Subscription $subscription
    ): bool {

        return (bool) $subscription->delete();
    }

    public function count(): int
    {
        return Subscription::query()->count();

    }

    public function countByStatus(
        SubscriptionStatus $status
    ): int {

        return Subscription::query()
            ->where(
                'status',
                $status
            )
            ->count();
    }

    /**
     * الاشتراكات المستحقة للتجديد.
     */
    public function findEligibleForAutoRenew(): Collection
    {
        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->where('status', SubscriptionStatus::ACTIVE)
            ->whereDate('end_date', '<=', Carbon::today())
            ->get();
    }

    public function findEligibleForGracePeriod(): Collection
    {
        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->where('status', SubscriptionStatus::ACTIVE)
            ->whereDate('end_date', '<', Carbon::today())
            ->get();
    }

    public function findEligibleForExpiration(): Collection
    {
        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->where('status', SubscriptionStatus::GRACE)
            ->whereDate('grace_end_date', '<=', Carbon::today())
            ->get();
    }
}
