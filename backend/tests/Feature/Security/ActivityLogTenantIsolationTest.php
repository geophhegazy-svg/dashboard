<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class ActivityLogTenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_user_cannot_list_activity_logs_from_another_tenant(): void
    {
        Permission::findOrCreate('activity.view', 'web');

        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $actor->givePermissionTo('activity.view');

        ActivityLog::create([
            'tenant_id' => $tenantA->id,
            'user_id' => $actor->id,
            'module' => 'test',
            'action' => 'tenant_a_action',
            'description' => 'Tenant A activity',
            'ip_address' => '127.0.0.1',
        ]);

        ActivityLog::create([
            'tenant_id' => $tenantB->id,
            'user_id' => $actor->id,
            'module' => 'test',
            'action' => 'tenant_b_action',
            'description' => 'Tenant B activity',
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->actingAs($actor, 'sanctum')
            ->getJson('/api/activity-logs');

        $response
            ->assertOk()
            ->assertJsonFragment([
                'description' => 'Tenant A activity',
            ])
            ->assertJsonMissing([
                'description' => 'Tenant B activity',
            ]);
    }

    public function test_tenant_user_cannot_show_activity_log_from_another_tenant(): void
    {
        Permission::findOrCreate('activity.view', 'web');

        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $actor->givePermissionTo('activity.view');

        $activityLog = ActivityLog::create([
            'tenant_id' => $tenantB->id,
            'user_id' => $actor->id,
            'module' => 'test',
            'action' => 'tenant_b_action',
            'description' => 'Tenant B secret activity',
            'ip_address' => '127.0.0.1',
        ]);

        $this->actingAs($actor, 'sanctum')
            ->getJson("/api/activity-logs/{$activityLog->id}")
            ->assertNotFound();
    }
}
