<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
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

        $subscription->save();

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

    public function suspended(): Collection
    {
        return $this->byStatus(
            SubscriptionStatus::SUSPENDED
        );
    }

    public function expired(): Collection
    {
        return $this->byStatus(
            SubscriptionStatus::EXPIRED
        );
    }

    public function cancelled(): Collection
    {
        return $this->byStatus(
            SubscriptionStatus::CANCELLED
        );
    }

    public function expiringSoon(
        int $days = 7
    ): Collection {

        return Subscription::query()
            ->where(
                'status',
                SubscriptionStatus::ACTIVE
            )
            ->whereBetween(
                'end_date',
                [
                    now(),
                    now()->addDays($days),
                ]
            )
            ->with([
                'customer',
                'package',
            ])
            ->get();
    }

    public function expiredCandidates(): Collection
    {
        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->where(
                'status',
                SubscriptionStatus::ACTIVE
            )
            ->where(
                'end_date',
                '<',
                now()
            )
            ->get();
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
