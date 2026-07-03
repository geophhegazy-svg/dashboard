<?php

namespace App\Policies;

use App\Models\User;

abstract class BasePolicy
{
    protected function allow(User $user, string $permission): bool
    {
        return $user->can($permission);
    }

    public function before(User $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }
}
