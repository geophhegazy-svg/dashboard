<?php

declare(strict_types=1);

namespace App\Core\Security\Authorization;

use App\Core\Security\Authorization\Concerns\AuthorizesByPermission;
use App\Models\User;

abstract class BasePolicy
{
    use AuthorizesByPermission;

    protected function allow(
        User $user,
        string $permission,
    ): bool {
        return $user->can($permission);
    }
}
