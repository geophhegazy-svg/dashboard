<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Tenancy;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class TenantContextInterfaceTest extends TestCase
{
    public function test_tenant_context_contract_exists_and_is_an_interface(): void
    {
        $reflection = new ReflectionClass(TenantContextInterface::class);

        self::assertTrue($reflection->isInterface());
    }

    public function test_tenant_context_contract_defines_required_methods(): void
    {
        $reflection = new ReflectionClass(TenantContextInterface::class);

        self::assertTrue($reflection->hasMethod('tenantId'));
        self::assertTrue($reflection->hasMethod('isGlobal'));

        self::assertSame(
            '?int',
            (string) $reflection->getMethod('tenantId')->getReturnType()
        );

        self::assertSame(
            'bool',
            (string) $reflection->getMethod('isGlobal')->getReturnType()
        );
    }
}
