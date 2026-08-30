<?php

declare(strict_types=1);

namespace App\Scopes;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class TenantScope implements Scope
{
    public function __construct(
        private readonly TenantContextInterface $tenantContext,
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        if ($this->tenantContext->isGlobal()) {
            return;
        }

        $tenantId = $this->tenantContext->tenantId();

        if ($tenantId === null) {
            return;
        }

        $builder->where(
            $model->getTable() . '.tenant_id',
            $tenantId,
        );
    }
}
