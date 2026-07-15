<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Contracts;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SubscriptionRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | CRUD
    |--------------------------------------------------------------------------
    */

    public function paginate(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator;

    public function find(
        int $id
    ): ?Subscription;

    public function findOrFail(
        int $id
    ): Subscription;

    public function create(
        array $attributes
    ): Subscription;

    public function update(
        Subscription $subscription,
        array $attributes
    ): Subscription;

    public function save(
        Subscription $subscription
    ): Subscription;

    public function delete(
        Subscription $subscription
    ): bool;

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    public function byCustomer(
        int $customerId
    ): Collection;

    public function byStatus(
        SubscriptionStatus $status
    ): Collection;

    public function active(): Collection;

    public function suspended(): Collection;

    public function expired(): Collection;

    public function cancelled(): Collection;

    public function expiringSoon(
        int $days = 7
    ): Collection;

    public function expiredCandidates(): Collection;

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    public function count(): int;

    public function countByStatus(
        SubscriptionStatus $status
    ): int;

    /**
     * الاشتراكات المستحقة للتجديد التلقائي.
     */
    public function findEligibleForAutoRenew(): Collection;

    /**
     * الاشتراكات التى ستدخل فترة السماح.
     */
    public function findEligibleForGracePeriod(): Collection;

    /**
     * الاشتراكات التى يجب إنهاؤها.
     */
    public function findEligibleForExpiration(): Collection;
}
