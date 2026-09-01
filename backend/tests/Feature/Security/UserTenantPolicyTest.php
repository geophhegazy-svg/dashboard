<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use App\Core\Security\Authorization\Policies\TenantPolicy;
use App\Core\Security\Authorization\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

final class UserTenantPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_policy_is_registered(): void
    {
        $policy = Gate::getPolicyFor(User::class);

        $this->assertInstanceOf(
            UserPolicy::class,
            $policy,
        );
    }

    public function test_tenant_policy_is_registered(): void
    {
        $policy = Gate::getPolicyFor(Tenant::class);

        $this->assertInstanceOf(
            TenantPolicy::class,
            $policy,
        );
    }

    public function test_user_policy_uses_user_permissions(): void
    {
        $user = User::factory()->create();

        $user->givePermissionTo([
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
        ]);

        $target = User::factory()->create();

        $this->assertTrue(
            Gate::forUser($user)->allows('viewAny', User::class)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('view', $target)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('create', User::class)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('update', $target)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('delete', $target)
        );
    }

    public function test_user_policy_denies_without_permissions(): void
    {
        $user = User::factory()->create();
        $target = User::factory()->create();

        $this->assertFalse(
            Gate::forUser($user)->allows('viewAny', User::class)
        );

        $this->assertFalse(
            Gate::forUser($user)->allows('create', User::class)
        );

        $this->assertFalse(
            Gate::forUser($user)->allows('update', $target)
        );

        $this->assertFalse(
            Gate::forUser($user)->allows('delete', $target)
        );
    }

    public function test_tenant_policy_uses_tenant_permissions(): void
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();

        $user->givePermissionTo([
            'tenants.view',
            'tenants.create',
            'tenants.update',
            'tenants.delete',
        ]);

        $this->assertTrue(
            Gate::forUser($user)->allows('viewAny', Tenant::class)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('view', $tenant)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('create', Tenant::class)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('update', $tenant)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('delete', $tenant)
        );
    }

    public function test_tenant_policy_denies_without_permissions(): void
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();

        $this->assertFalse(
            Gate::forUser($user)->allows('viewAny', Tenant::class)
        );

        $this->assertFalse(
            Gate::forUser($user)->allows('create', Tenant::class)
        );

        $this->assertFalse(
            Gate::forUser($user)->allows('update', $tenant)
        );

        $this->assertFalse(
            Gate::forUser($user)->allows('delete', $tenant)
        );
    }

    public function test_tenant_user_cannot_view_user_from_another_tenant(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $target = User::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $user->givePermissionTo('users.view');

        $this->assertFalse(
            Gate::forUser($user)->allows('view', $target)
        );
    }

    public function test_tenant_user_cannot_update_user_from_another_tenant(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $target = User::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $user->givePermissionTo('users.update');

        $this->assertFalse(
            Gate::forUser($user)->allows('update', $target)
        );
    }

    public function test_tenant_user_cannot_delete_user_from_another_tenant(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $target = User::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $user->givePermissionTo('users.delete');

        $this->assertFalse(
            Gate::forUser($user)->allows('delete', $target)
        );
    }

    public function test_tenant_user_can_access_user_from_same_tenant(): void
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $target = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $user->givePermissionTo([
            'users.view',
            'users.update',
            'users.delete',
        ]);

        $this->assertTrue(
            Gate::forUser($user)->allows('view', $target)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('update', $target)
        );

        $this->assertTrue(
            Gate::forUser($user)->allows('delete', $target)
        );
    }

}
