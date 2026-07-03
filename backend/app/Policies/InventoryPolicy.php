<?php

namespace App\Policies;

use App\Models\Inventory;
use App\Models\User;
use App\Policies\Concerns\AuthorizesByPermission;

class InventoryPolicy
{
    use AuthorizesByPermission;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->can($user, 'inventory.viewAny');
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inventory $inventory): bool
    {
        return $this->can($user, 'inventory.view');
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->can($user, 'inventory.create');
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inventory $inventory): bool
    {
        return $this->can($user, 'inventory.update');
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inventory $inventory): bool
    {
        return $this->can($user, 'inventory.delete');
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inventory $inventory): bool
    {
        return $this->can($user, 'inventory.restore');
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inventory $inventory): bool
    {
        return $this->can($user, 'inventory.forceDelete');
        return false;
    }
}
