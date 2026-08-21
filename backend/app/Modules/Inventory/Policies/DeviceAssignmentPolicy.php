<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Policies;

use App\Core\Security\Authorization\BasePolicy;
use App\Models\User;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;

final class DeviceAssignmentPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allow($user, 'device-assignments.viewAny');
    }

    public function view(
        User $user,
        DeviceAssignment $deviceAssignment
    ): bool {
        return $this->allow($user, 'device-assignments.view');
    }

    public function create(User $user): bool
    {
        return $this->allow($user, 'device-assignments.create');
    }

    public function update(
        User $user,
        DeviceAssignment $deviceAssignment
    ): bool {
        return $this->allow($user, 'device-assignments.update');
    }

    public function delete(
        User $user,
        DeviceAssignment $deviceAssignment
    ): bool {
        return $this->allow($user, 'device-assignments.delete');
    }
}
