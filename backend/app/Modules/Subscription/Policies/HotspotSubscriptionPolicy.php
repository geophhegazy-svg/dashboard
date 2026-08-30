<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Policies;

use App\Core\Security\Authorization\BasePolicy;
use App\Models\User;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;

final class HotspotSubscriptionPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allow($user, 'subscriptions.view');
    }

    public function view(
        User $user,
        HotspotSubscription $hotspotSubscription
    ): bool {
        return $this->allow($user, 'subscriptions.view');
    }

    public function create(User $user): bool
    {
        return $this->allow($user, 'subscriptions.create');
    }

    public function update(
        User $user,
        HotspotSubscription $hotspotSubscription
    ): bool {
        return $this->allow($user, 'subscriptions.update');
    }

    public function delete(
        User $user,
        HotspotSubscription $hotspotSubscription
    ): bool {
        return $this->allow($user, 'subscriptions.delete');
    }

    public function activate(
        User $user,
        HotspotSubscription $hotspotSubscription
    ): bool {
        return $this->allow($user, 'subscriptions.activate');
    }

    public function suspend(
        User $user,
        HotspotSubscription $hotspotSubscription
    ): bool {
        return $this->allow($user, 'subscriptions.suspend');
    }
}
