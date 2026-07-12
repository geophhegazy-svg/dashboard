<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SubscriptionRepositoryInterface
{
    /**
     * Paginated subscriptions.
     */
    public function paginate(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator;

    /**
     * Find subscription.
     */
    public function find(
        int $id
    ): ?Subscription;

    /**
     * Find or fail.
     */
    public function findOrFail(
        int $id
    ): Subscription;

    /**
     * Create subscription.
     */
    public function create(
        array $attributes
    ): Subscription;

    /**
     * Update subscription.
     */
    public function update(
        Subscription $subscription,
        array $attributes
    ): Subscription;

    /**
     * Persist subscription.
     */
    public function save(
        Subscription $subscription
    ): Subscription;

    /**
     * Delete subscription.
     */
    public function delete(
        Subscription $subscription
    ): bool;

    /**
     * Customer subscriptions.
     */
    public function byCustomer(
        int $customerId
    ): Collection;

    /**
     * Subscriptions by status.
     */
    public function byStatus(
        SubscriptionStatus $status
    ): Collection;

    /**
     * Active subscriptions.
     */
    public function active(): Collection;

    /**
     * Expired subscriptions.
     */
    public function expired(): Collection;
}
