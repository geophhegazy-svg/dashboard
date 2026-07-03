<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Package;
use App\Models\User;
use App\Policies\Concerns\AuthorizesByPermission;

class PackagePolicy
{
    use AuthorizesByPermission;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'packages.viewAny');
    }

    public function view(User $user, Package $package): bool
    {
        return $this->can($user, 'packages.view');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'packages.create');
    }

    public function update(User $user, Package $package): bool
    {
        return $this->can($user, 'packages.update');
    }

    public function delete(User $user, Package $package): bool
    {
        return $this->can($user, 'packages.delete');
    }

    public function restore(User $user, Package $package): bool
    {
        return $this->can($user, 'packages.restore');
        return false;
    }

    public function forceDelete(User $user, Package $package): bool
    {
        return $this->can($user, 'packages.forceDelete');
        return false;
    }
}
