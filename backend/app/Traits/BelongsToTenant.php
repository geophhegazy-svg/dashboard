<?php

declare(strict_types=1);

namespace App\Traits;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use App\Scopes\TenantScope;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(
            app(TenantScope::class),
        );

        static::creating(function ($model): void {
            if ($model->tenant_id) {
                return;
            }

            $tenantId = app(TenantContextInterface::class)->tenantId();

            if ($tenantId !== null) {
                $model->tenant_id = $tenantId;
            }
        });
    }
}
