<?php

declare(strict_types=1);

namespace App\Core\Security\Authorization\Concerns;

use App\Core\Security\Authorization\Contracts\AuthorizableInterface;

trait AuthorizesByPermission
{
    public function before(AuthorizableInterface $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }

    protected function can(AuthorizableInterface $user, string $permission): bool
    {
        return $user->can($permission);
    }
}
