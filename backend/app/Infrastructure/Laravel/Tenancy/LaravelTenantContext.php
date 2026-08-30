<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Tenancy;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use Illuminate\Contracts\Auth\Guard;

final readonly class LaravelTenantContext implements TenantContextInterface
{
    public function __construct(
        private Guard $auth,
    ) {
    }

    public function tenantId(): ?int
    {
        $user = $this->auth->user();

        if ($user === null || $user->tenant_id === null) {
            return null;
        }

        return (int) $user->tenant_id;
    }

    public function isGlobal(): bool
    {
        $user = $this->auth->user();

        if ($user === null) {
            return true;
        }

        if (method_exists($user, 'hasRole') && $user->hasRole('Super Admin')) {
            return true;
        }

        return $this->tenantId() === null;
    }
}
