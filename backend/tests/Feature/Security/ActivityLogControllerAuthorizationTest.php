<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Activity\Policies\ActivityLogPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

final class ActivityLogControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_activity_log_policy_is_registered(): void
    {
        $policy = Gate::getPolicyFor(ActivityLog::class);

        $this->assertInstanceOf(
            ActivityLogPolicy::class,
            $policy,
        );
    }

    public function test_activity_log_index_requires_view_permission(): void
    {
        $actor = User::factory()->create();

        $this->actingAs($actor, 'sanctum')
            ->getJson('/api/activity-logs')
            ->assertForbidden();
    }

    public function test_activity_log_index_allows_view_permission(): void
    {
        $actor = User::factory()->create();
        $actor->givePermissionTo('activity.view');

        $this->actingAs($actor, 'sanctum')
            ->getJson('/api/activity-logs')
            ->assertOk();
    }

    public function test_activity_log_show_requires_view_permission(): void
    {
        $tenant = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $activityLog = ActivityLog::create([
            'tenant_id' => $tenant->id,
            'user_id' => $actor->id,
            'module' => 'test',
            'action' => 'test_action',
            'description' => 'Authorization test',
            'ip_address' => '127.0.0.1',
        ]);

        $this->actingAs($actor, 'sanctum')
            ->getJson("/api/activity-logs/{$activityLog->id}")
            ->assertForbidden();
    }

    public function test_activity_log_show_allows_view_permission(): void
    {
        $tenant = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $actor->givePermissionTo('activity.view');

        $activityLog = ActivityLog::create([
            'tenant_id' => $tenant->id,
            'user_id' => $actor->id,
            'module' => 'test',
            'action' => 'test_action',
            'description' => 'Authorization test',
            'ip_address' => '127.0.0.1',
        ]);

        $this->actingAs($actor, 'sanctum')
            ->getJson("/api/activity-logs/{$activityLog->id}")
            ->assertOk();
    }
}
