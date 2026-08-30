<?php

declare(strict_types=1);

namespace App\Core\Tenancy\Contracts;

interface TenantContextInterface
{
    public function tenantId(): ?int;

    public function isGlobal(): bool;
}
