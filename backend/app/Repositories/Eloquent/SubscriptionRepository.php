<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\SubscriptionStatus;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function find(int $id): ?Subscription
    {
        return Subscription::find($id);
    }

    public function all(): Collection
    {
        return Subscription::all();
    }

    public function save(Subscription $subscription): bool
    {
        return $subscription->save();
    }

    public function delete(Subscription $subscription): bool
    {
        return (bool) $subscription->delete();
    }

    public function linkedPppoeUsers(): array
    {
        return Subscription::query()
            ->whereNotNull('pppoe_username')
            ->pluck('pppoe_username')
            ->toArray();
    }

    public function pppoeAlreadyLinked(
        string $username,
        ?int $exceptId = null
    ): bool {

        $query = Subscription::query()
            ->where('pppoe_username', $username);

        if ($exceptId !== null) {
            $query->whereKeyNot($exceptId);
        }

        return $query->exists();
    }

    public function expiringSubscriptions(): Collection
    {
        return Subscription::query()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->whereDate('end_date', '<=', now())
            ->get();
    }

    public function usernameExists(
        string $username,
        int $ignoreId = 0
    ): bool {

        return Subscription::query()
            ->where('pppoe_username', $username)
            ->whereKeyNot($ignoreId)
            ->exists();
    }

    public function updatePppoe(
        Subscription $subscription,
        string $username
    ): bool {

        return $subscription->update([
            'pppoe_username' => $username,
        ]);
    }
}
