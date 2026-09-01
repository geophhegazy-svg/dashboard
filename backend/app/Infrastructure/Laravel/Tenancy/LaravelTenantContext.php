<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Tenancy;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use Illuminate\Http\Request;

final readonly class LaravelTenantContext implements TenantContextInterface
{
    public function __construct(
        private Request $request,
    ) {
    }

    public function tenantId(): ?int
    {
        $user = $this->request->user();

        if ($user === null || $user->tenant_id === null) {
            return null;
        }

        return (int) $user->tenant_id;
    }

    public function isGlobal(): bool
    {
        $user = $this->request->user();

        if ($user === null) {
            return true;
        }

        if (method_exists($user, 'hasRole') && $user->hasRole('Super Admin')) {
            return true;
        }

        return $this->tenantId() === null;
    }
}
