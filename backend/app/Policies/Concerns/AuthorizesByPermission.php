<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait AuthorizesByPermission
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }

    protected function can(User $user, string $permission): bool
    {
        return $user->can($permission);
    }
}
