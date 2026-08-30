<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Tenancy;

use App\Infrastructure\Laravel\Tenancy\LaravelTenantContext;
use Illuminate\Contracts\Auth\Guard;
use PHPUnit\Framework\TestCase;

final class LaravelTenantContextTest extends TestCase
{
    public function test_it_returns_authenticated_user_tenant_id(): void
    {
        $user = (object) ['tenant_id' => 42];

        $auth = $this->createMock(Guard::class);
        $auth->expects(self::once())
            ->method('user')
            ->willReturn($user);

        $context = new LaravelTenantContext($auth);

        self::assertSame(42, $context->tenantId());
    }

    public function test_it_is_not_global_when_authenticated_user_has_a_tenant(): void
    {
        $user = (object) ['tenant_id' => 42];

        $auth = $this->createMock(Guard::class);
        $auth->method('user')->willReturn($user);

        $context = new LaravelTenantContext($auth);

        self::assertFalse($context->isGlobal());
    }

    public function test_it_is_global_for_super_admin_even_when_user_has_a_tenant(): void
    {
        $user = new class {
            public ?int $tenant_id = 42;

            public function hasRole(string $role): bool
            {
                return $role === 'Super Admin';
            }
        };

        $auth = $this->createMock(Guard::class);
        $auth->method('user')->willReturn($user);

        $context = new LaravelTenantContext($auth);

        self::assertSame(42, $context->tenantId());
        self::assertTrue($context->isGlobal());
    }

    public function test_it_returns_null_when_no_authenticated_user_exists(): void
    {
        $auth = $this->createMock(Guard::class);
        $auth->expects(self::once())
            ->method('user')
            ->willReturn(null);

        $context = new LaravelTenantContext($auth);

        self::assertNull($context->tenantId());
    }

    public function test_it_is_global_when_no_authenticated_user_exists(): void
    {
        $auth = $this->createMock(Guard::class);
        $auth->method('user')->willReturn(null);

        $context = new LaravelTenantContext($auth);

        self::assertTrue($context->isGlobal());
    }

    public function test_it_returns_null_when_authenticated_user_has_no_tenant(): void
    {
        $user = (object) ['tenant_id' => null];

        $auth = $this->createMock(Guard::class);
        $auth->expects(self::once())
            ->method('user')
            ->willReturn($user);

        $context = new LaravelTenantContext($auth);

        self::assertNull($context->tenantId());
    }

    public function test_it_is_global_when_authenticated_user_has_no_tenant(): void
    {
        $user = (object) ['tenant_id' => null];

        $auth = $this->createMock(Guard::class);
        $auth->method('user')->willReturn($user);

        $context = new LaravelTenantContext($auth);

        self::assertTrue($context->isGlobal());
    }
}
