<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Tenancy;

use App\Infrastructure\Laravel\Tenancy\LaravelTenantContext;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

final class LaravelTenantContextTest extends TestCase
{
    public function test_it_returns_authenticated_user_tenant_id(): void
    {
        $request = Request::create('/');

        $user = (object) ['tenant_id' => 42];

        $request->setUserResolver(
            static fn () => $user,
        );

        $context = new LaravelTenantContext($request);

        self::assertSame(42, $context->tenantId());
    }

    public function test_it_is_not_global_when_authenticated_user_has_a_tenant(): void
    {
        $request = Request::create('/');

        $user = (object) ['tenant_id' => 42];

        $request->setUserResolver(
            static fn () => $user,
        );

        $context = new LaravelTenantContext($request);

        self::assertFalse($context->isGlobal());
    }

    public function test_it_is_global_for_super_admin_even_when_user_has_a_tenant(): void
    {
        $request = Request::create('/');

        $user = new class {
            public ?int $tenant_id = 42;

            public function hasRole(string $role): bool
            {
                return $role === 'Super Admin';
            }
        };

        $request->setUserResolver(
            static fn () => $user,
        );

        $context = new LaravelTenantContext($request);

        self::assertSame(42, $context->tenantId());
        self::assertTrue($context->isGlobal());
    }

    public function test_it_returns_null_when_no_authenticated_user_exists(): void
    {
        $request = Request::create('/');

        $request->setUserResolver(
            static fn () => null,
        );

        $context = new LaravelTenantContext($request);

        self::assertNull($context->tenantId());
    }

    public function test_it_is_global_when_no_authenticated_user_exists(): void
    {
        $request = Request::create('/');

        $request->setUserResolver(
            static fn () => null,
        );

        $context = new LaravelTenantContext($request);

        self::assertTrue($context->isGlobal());
    }

    public function test_it_returns_null_when_authenticated_user_has_no_tenant(): void
    {
        $request = Request::create('/');

        $user = (object) ['tenant_id' => null];

        $request->setUserResolver(
            static fn () => $user,
        );

        $context = new LaravelTenantContext($request);

        self::assertNull($context->tenantId());
    }

    public function test_it_is_global_when_authenticated_user_has_no_tenant(): void
    {
        $request = Request::create('/');

        $user = (object) ['tenant_id' => null];

        $request->setUserResolver(
            static fn () => $user,
        );

        $context = new LaravelTenantContext($request);

        self::assertTrue($context->isGlobal());
    }
}
