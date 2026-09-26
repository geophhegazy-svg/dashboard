<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class DashboardControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_index_requires_dashboard_view_permission(): void
    {
        $user = User::factory()->create();

        Permission::findOrCreate('dashboard.view', 'web');

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/dashboard')
            ->assertForbidden();
    }

    public function test_dashboard_stats_requires_dashboard_statistics_permission(): void
    {
        $user = User::factory()->create();

        Permission::findOrCreate('dashboard.statistics', 'web');

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/dashboard/stats')
            ->assertForbidden();
    }

    public function test_dashboard_index_allows_dashboard_view_permission(): void
    {
        $user = User::factory()->create();

        $permission = Permission::findOrCreate('dashboard.view', 'web');
        $user->givePermissionTo($permission);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/dashboard')
            ->assertOk()
            ->assertJsonStructure([
                'totalUsers',
                'onlineUsers',
                'activeUsers',
                'totalDevices',
                'onlineDevices',
                'onlineUsersLastSyncAt',
                'onlineDevicesLastSyncAt',
            ]);
    }

    public function test_dashboard_stats_allows_dashboard_statistics_permission(): void
    {
        $user = User::factory()->create();

        $permission = Permission::findOrCreate('dashboard.statistics', 'web');
        $user->givePermissionTo($permission);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/dashboard/stats')
            ->assertOk()
            ->assertJsonStructure([
                'totalUsers',
                'onlineUsers',
                'totalDevices',
                'onlineDevices',
                'onlineUsersLastSyncAt',
                'onlineDevicesLastSyncAt',
            ]);
    }
}
