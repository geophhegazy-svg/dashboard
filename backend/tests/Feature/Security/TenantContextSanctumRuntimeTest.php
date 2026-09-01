<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class TenantContextSanctumRuntimeTest extends TestCase
{
    use RefreshDatabase;

    public function test_sanctum_request_populates_tenant_context(): void
    {
        Permission::findOrCreate('activity.view', 'web');

        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $user->givePermissionTo('activity.view');

        Sanctum::actingAs($user);

        $this->getJson('/api/activity-logs')
            ->assertOk();

        $context = app(TenantContextInterface::class);

        dump([
            'user_id' => $user->id,
            'user_tenant_id' => $user->tenant_id,
            'context_tenant_id' => $context->tenantId(),
            'context_is_global' => $context->isGlobal(),
            'default_guard_user' => auth()->user()?->id,
            'sanctum_guard_user' => auth()->guard('sanctum')->user()?->id,
        ]);

        self::assertSame($tenant->id, $context->tenantId());
        self::assertFalse($context->isGlobal());
    }
}
