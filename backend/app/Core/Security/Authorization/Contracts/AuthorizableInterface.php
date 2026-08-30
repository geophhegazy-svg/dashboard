<?php

declare(strict_types=1);

namespace App\Core\Security\Authorization\Contracts;

interface AuthorizableInterface
{
    public function can($abilities, $arguments = []);

    public function hasRole($roles, ?string $guard = null): bool;
}
