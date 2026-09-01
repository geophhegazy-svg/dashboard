<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use App\Models\Tenant;
use App\Models\User;
use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class ActivityLogTenantScopeRuntimeTest extends TestCase
{
    use RefreshDatabase;

    public function test_activity_log_scope_is_applied_inside_sanctum_request(): void
    {
        Permission::findOrCreate('activity.view', 'web');

        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $user->givePermissionTo('activity.view');

        ActivityLog::create([
            'tenant_id' => $tenantA->id,
            'user_id' => $user->id,
            'module' => 'test',
            'action' => 'tenant_a',
            'description' => 'Tenant A activity',
            'ip_address' => '127.0.0.1',
        ]);

        ActivityLog::create([
            'tenant_id' => $tenantB->id,
            'user_id' => $user->id,
            'module' => 'test',
            'action' => 'tenant_b',
            'description' => 'Tenant B activity',
            'ip_address' => '127.0.0.1',
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/activity-logs')
            ->assertOk();

        $context = app(TenantContextInterface::class);

        dump([
            'user_tenant_id' => $user->tenant_id,
            'context_tenant_id' => $context->tenantId(),
            'context_is_global' => $context->isGlobal(),
            'response_count' => count($response->json('data')),
            'response_descriptions' => collect($response->json('data'))
                ->pluck('description')
                ->all(),
        ]);

        self::assertSame($tenantA->id, $context->tenantId());
        self::assertFalse($context->isGlobal());

        $response
            ->assertJsonFragment([
                'description' => 'Tenant A activity',
            ])
            ->assertJsonMissing([
                'description' => 'Tenant B activity',
            ]);

        self::assertCount(1, $response->json('data'));

        self::assertCount(
            1,
            ActivityLog::query()->get(),
        );
    }
}
