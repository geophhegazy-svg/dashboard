<?php

namespace App\Core\Security\Authorization\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Core\Security\Authorization\Concerns\AuthorizesByPermission;

class UserPolicy
{
    use AuthorizesByPermission;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->can($user, 'users.view');
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $this->sameTenantOrSuperAdmin($user, $model)
            && $this->can($user, 'users.view');
    }


    private function sameTenantOrSuperAdmin(User $user, User $model): bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        if ($user->tenant_id === null) {
            return true;
        }

        return $user->tenant_id === $model->tenant_id;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->can($user, 'users.create');
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $this->sameTenantOrSuperAdmin($user, $model)
            && $this->can($user, 'users.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $this->sameTenantOrSuperAdmin($user, $model)
            && $this->can($user, 'users.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $this->can($user, 'users.update');
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $this->can($user, 'users.delete');
        return false;
    }
}
