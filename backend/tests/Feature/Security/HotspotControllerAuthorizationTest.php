<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class HotspotControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_online_users_requires_authentication(): void
    {
        $response = $this->getJson('/api/hotspot/online');

        $response->assertUnauthorized();
    }

    public function test_stats_requires_authentication(): void
    {
        $response = $this->getJson('/api/hotspot/stats');

        $response->assertUnauthorized();
    }

    public function test_online_users_requires_mikrotik_hotspot_view_permission(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Customer');

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/hotspot/online');

        $response->assertForbidden();
    }

    public function test_stats_requires_mikrotik_hotspot_view_permission(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Customer');

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/hotspot/stats');

        $response->assertForbidden();
    }

    public function test_technician_with_mikrotik_hotspot_view_can_read_online_users(): void
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $user->assignRole('Technician');

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/hotspot/online');

        $response
            ->assertOk()
            ->assertJsonPath('status', 'success');
    }

    public function test_technician_with_mikrotik_hotspot_view_can_read_stats(): void
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $user->assignRole('Technician');

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/hotspot/stats');

        $response
            ->assertOk()
            ->assertJsonPath('status', 'success');
    }
}
