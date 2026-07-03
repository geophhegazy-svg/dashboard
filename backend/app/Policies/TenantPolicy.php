<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Policies\Concerns\AuthorizesByPermission;

class TenantPolicy
{
    use AuthorizesByPermission;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->can($user, 'tenants.viewAny');
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tenant $tenant): bool
    {
        return $this->can($user, 'tenants.view');
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->can($user, 'tenants.create');
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tenant $tenant): bool
    {
        return $this->can($user, 'tenants.update');
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tenant $tenant): bool
    {
        return $this->can($user, 'tenants.delete');
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tenant $tenant): bool
    {
        return $this->can($user, 'tenants.restore');
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tenant $tenant): bool
    {
        return $this->can($user, 'tenants.forceDelete');
        return false;
    }
}
