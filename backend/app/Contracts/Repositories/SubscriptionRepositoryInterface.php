<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SubscriptionRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | Query Operations
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

    public function byCustomer(
        int $customerId
    ): Collection;

    public function byStatus(
        SubscriptionStatus $status
    ): Collection;

    public function active(): Collection;

    public function expired(): Collection;

    /*
    |--------------------------------------------------------------------------
    | Persistence Operations
    |--------------------------------------------------------------------------
    */

    public function create(
        array $attributes
    ): Subscription;

    public function save(
        Subscription $subscription
    ): Subscription;

    public function update(
        Subscription $subscription,
        array $attributes
    ): Subscription;

    public function delete(
        Subscription $subscription
    ): bool;
}
