<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Policies;

use App\Core\Security\Authorization\BasePolicy;
use App\Models\User;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;

final class DevicePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allow($user, 'devices.viewAny');
    }

    public function view(User $user, Device $device): bool
    {
        return $this->allow($user, 'devices.view');
    }

    public function create(User $user): bool
    {
        return $this->allow($user, 'devices.create');
    }

    public function update(User $user, Device $device): bool
    {
        return $this->allow($user, 'devices.update');
    }

    public function delete(User $user, Device $device): bool
    {
        return $this->allow($user, 'devices.delete');
    }

    public function restore(User $user, Device $device): bool
    {
        return $this->allow($user, 'devices.restore');
    }

    public function forceDelete(User $user, Device $device): bool
    {
        return $this->allow($user, 'devices.forceDelete');
    }
}
