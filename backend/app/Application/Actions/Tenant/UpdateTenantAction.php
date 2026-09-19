<?php

declare(strict_types=1);

namespace App\Application\Actions\Tenant;

use App\Models\Tenant;

final readonly class UpdateTenantAction
{
    public function execute(
        Tenant $tenant,
        array $data,
    ): Tenant {
        $tenant->update($data);

        return $tenant->refresh();
    }
}
