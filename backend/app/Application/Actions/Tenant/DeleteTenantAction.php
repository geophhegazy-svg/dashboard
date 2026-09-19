<?php

declare(strict_types=1);

namespace App\Application\Actions\Tenant;

use App\Models\Tenant;

final readonly class DeleteTenantAction
{
    public function execute(Tenant $tenant): bool
    {
        return $tenant->delete();
    }
}
