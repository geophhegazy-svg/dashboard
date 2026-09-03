<?php

declare(strict_types=1);

namespace Tests\Unit\Scopes;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class TenantScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_user_sees_only_packages_belonging_to_their_tenant(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        Package::factory()->create([
            'tenant_id' => $tenantA->id,
            'name' => 'Tenant A Package',
        ]);

        Package::factory()->create([
            'tenant_id' => $tenantB->id,
            'name' => 'Tenant B Package',
        ]);

        app('request')->setUserResolver(fn () => $user);

        $packages = Package::query()->get();

        self::assertCount(1, $packages);
        self::assertSame('Tenant A Package', $packages->first()->name);
        self::assertSame($tenantA->id, $packages->first()->tenant_id);
    }

    public function test_super_admin_sees_packages_from_all_tenants(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $user->assignRole('Super Admin');

        Package::factory()->create([
            'tenant_id' => $tenantA->id,
            'name' => 'Tenant A Package',
        ]);

        Package::factory()->create([
            'tenant_id' => $tenantB->id,
            'name' => 'Tenant B Package',
        ]);

        app('request')->setUserResolver(fn () => $user);

        $packages = Package::query()->get();

        self::assertCount(2, $packages);
        self::assertEqualsCanonicalizing(
            [
                'Tenant A Package',
                'Tenant B Package',
            ],
            $packages->pluck('name')->all(),
        );
    }

    public function test_guest_context_is_global(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        Package::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        Package::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        app('request')->setUserResolver(fn () => null);

        self::assertCount(2, Package::query()->get());
    }

    public function test_tenant_user_automatically_gets_tenant_id_when_creating_package(): void
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        app('request')->setUserResolver(fn () => $user);

        $package = Package::query()->create([
            'name' => 'Auto Tenant Package',
            'download_speed' => 30,
            'upload_speed' => 10,
            'price' => 350,
            'quota_gb' => 500,
            'status' => 'active',
        ]);

        self::assertSame($tenant->id, $package->tenant_id);
    }

    public function test_explicit_tenant_id_is_not_overridden(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        app('request')->setUserResolver(fn () => $user);

        $package = Package::query()->create([
            'tenant_id' => $tenantB->id,
            'name' => 'Explicit Tenant Package',
            'download_speed' => 30,
            'upload_speed' => 10,
            'price' => 350,
            'quota_gb' => 500,
            'status' => 'active',
        ]);

        self::assertSame($tenantB->id, $package->tenant_id);
    }
}
