<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Contracts;

use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use Illuminate\Pagination\LengthAwarePaginator;

interface HotspotSubscriptionRepositoryInterface
{
    public function paginate(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator;

    public function find(
        int $id
    ): ?HotspotSubscription;

    public function findOrFail(
        int $id
    ): HotspotSubscription;

    public function create(
        array $attributes
    ): HotspotSubscription;

    public function update(
        HotspotSubscription $subscription,
        array $attributes
    ): HotspotSubscription;

    public function save(
        HotspotSubscription $subscription
    ): HotspotSubscription;

    public function delete(
        HotspotSubscription $subscription
    ): bool;
}
