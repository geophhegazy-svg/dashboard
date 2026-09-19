<?php

declare(strict_types=1);

namespace App\Application\Actions\Tenant;

use App\Models\Tenant;

final readonly class CreateTenantAction
{
    public function execute(array $data): Tenant
    {
        return Tenant::create($data);
    }
}
