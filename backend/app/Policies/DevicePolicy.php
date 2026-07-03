<?php

namespace App\Policies;

use App\Models\Device;
use App\Models\User;
use App\Policies\Concerns\AuthorizesByPermission;

class DevicePolicy
{
    use AuthorizesByPermission;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->can($user, 'devices.viewAny');
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Device $device): bool
    {
        return $this->can($user, 'devices.view');
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->can($user, 'devices.create');
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Device $device): bool
    {
        return $this->can($user, 'devices.update');
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Device $device): bool
    {
        return $this->can($user, 'devices.delete');
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Device $device): bool
    {
        return $this->can($user, 'devices.restore');
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Device $device): bool
    {
        return $this->can($user, 'devices.forceDelete');
        return false;
    }
}
