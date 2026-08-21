<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Policies;

use App\Core\Security\Authorization\BasePolicy;
use App\Models\User;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;

final class InventoryPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allow($user, 'inventory.viewAny');
    }

    public function view(User $user, Inventory $inventory): bool
    {
        return $this->allow($user, 'inventory.view');
    }

    public function create(User $user): bool
    {
        return $this->allow($user, 'inventory.create');
    }

    public function update(User $user, Inventory $inventory): bool
    {
        return $this->allow($user, 'inventory.update');
    }

    public function delete(User $user, Inventory $inventory): bool
    {
        return $this->allow($user, 'inventory.delete');
    }

    public function restore(User $user, Inventory $inventory): bool
    {
        return $this->allow($user, 'inventory.restore');
    }

    public function forceDelete(User $user, Inventory $inventory): bool
    {
        return $this->allow($user, 'inventory.forceDelete');
    }
}
