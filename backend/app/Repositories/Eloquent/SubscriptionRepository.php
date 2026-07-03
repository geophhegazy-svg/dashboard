<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function find(int $id): ?Subscription
    {
        return Subscription::find($id);
    }

    public function save(Subscription $subscription): bool
    {
        return $subscription->save();
    }

    public function delete(Subscription $subscription): bool
    {
        return (bool) $subscription->delete();
    }

    public function all(): Collection
    {
        return Subscription::all();
    }
}
