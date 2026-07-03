<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use App\Policies\Concerns\AuthorizesByPermission;

class SubscriptionPolicy
{
    use AuthorizesByPermission;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'subscriptions.view');
    }

    public function view(User $user, Subscription $subscription): bool
    {
        return $this->can($user, 'subscriptions.view');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'subscriptions.create');
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $this->can($user, 'subscriptions.update');
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $this->can($user, 'subscriptions.delete');
    }

    public function activate(User $user, Subscription $subscription): bool
    {
        return $this->can($user, 'subscriptions.activate');
    }

    public function suspend(User $user, Subscription $subscription): bool
    {
        return $this->can($user, 'subscriptions.suspend');
    }

    public function renew(User $user, Subscription $subscription): bool
    {
        return $this->can($user, 'subscriptions.renew');
    }

    public function restore(User $user, Subscription $subscription): bool
    {
        return $this->can($user, 'subscriptions.restore');
    }

    public function expire(User $user, Subscription $subscription): bool
    {
        return $this->can($user, 'subscriptions.expire');
    }
}
