<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Api\Network;

use App\Models\User;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\PppoeServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

final class PppoeHotspotControlApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_pppoe_requires_view_permission(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->getJson('/api/network/pppoe?device_id=1')
            ->assertForbidden();
    }

    public function test_hotspot_requires_view_permission(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->getJson('/api/network/hotspot?device_id=1')
            ->assertForbidden();
    }

    public function test_pppoe_requires_device_id(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('mikrotik.pppoe.view');

        Sanctum::actingAs($user);

        $this->getJson('/api/network/pppoe')
            ->assertStatus(422);
    }

    public function test_hotspot_requires_device_id(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('mikrotik.hotspot.view');

        Sanctum::actingAs($user);

        $this->getJson('/api/network/hotspot')
            ->assertStatus(422);
    }

    public function test_pppoe_index_delegates_to_provider(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('mikrotik.pppoe.view');

        Sanctum::actingAs($user);

        $pppoe = Mockery::mock(PppoeServiceInterface::class);
        $pppoe->shouldReceive('getAllUsers')
            ->once()
            ->andReturn([
                ['name' => 'user01'],
            ]);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('pppoe')
            ->once()
            ->andReturn($pppoe);

        $this->app->instance(
            NetworkManagerInterface::class,
            Mockery::mock(NetworkManagerInterface::class, function ($mock) use ($provider): void {
                $mock->shouldReceive('connect')
                    ->with(7)
                    ->once()
                    ->andReturn(true);

                $mock->shouldReceive('provider')
                    ->once()
                    ->andReturn($provider);
            })
        );

        $this->getJson('/api/network/pppoe?device_id=7')
            ->assertOk()
            ->assertJson([
                'data' => [
                    ['name' => 'user01'],
                ],
            ]);
    }

    public function test_hotspot_index_delegates_to_provider(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('mikrotik.hotspot.view');

        Sanctum::actingAs($user);

        $hotspot = Mockery::mock(HotspotServiceInterface::class);
        $hotspot->shouldReceive('getUsers')
            ->once()
            ->andReturn([
                ['name' => 'hotspot01'],
            ]);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('hotspot')
            ->once()
            ->andReturn($hotspot);

        $this->app->instance(
            NetworkManagerInterface::class,
            Mockery::mock(NetworkManagerInterface::class, function ($mock) use ($provider): void {
                $mock->shouldReceive('connect')
                    ->with(8)
                    ->once()
                    ->andReturn(true);

                $mock->shouldReceive('provider')
                    ->once()
                    ->andReturn($provider);
            })
        );

        $this->getJson('/api/network/hotspot?device_id=8')
            ->assertOk()
            ->assertJson([
                'data' => [
                    ['name' => 'hotspot01'],
                ],
            ]);
    }

    public function test_pppoe_toggle_uses_update_permission_and_provider(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('mikrotik.pppoe.update');

        Sanctum::actingAs($user);

        $pppoe = Mockery::mock(PppoeServiceInterface::class);
        $pppoe->shouldReceive('disableUser')
            ->with('user01')
            ->once()
            ->andReturn(true);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('pppoe')
            ->once()
            ->andReturn($pppoe);

        $this->app->instance(
            NetworkManagerInterface::class,
            Mockery::mock(NetworkManagerInterface::class, function ($mock) use ($provider): void {
                $mock->shouldReceive('connect')
                    ->with(9)
                    ->once()
                    ->andReturn(true);

                $mock->shouldReceive('provider')
                    ->once()
                    ->andReturn($provider);
            })
        );

        $this->patchJson('/api/network/pppoe/user01/toggle', [
            'device_id' => 9,
            'action' => 'disable',
        ])
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_hotspot_disconnect_uses_view_permission_and_provider(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('mikrotik.hotspot.view');

        Sanctum::actingAs($user);

        $hotspot = Mockery::mock(HotspotServiceInterface::class);
        $hotspot->shouldReceive('disconnectUser')
            ->with('hotspot01')
            ->once()
            ->andReturn(true);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('hotspot')
            ->once()
            ->andReturn($hotspot);

        $this->app->instance(
            NetworkManagerInterface::class,
            Mockery::mock(NetworkManagerInterface::class, function ($mock) use ($provider): void {
                $mock->shouldReceive('connect')
                    ->with(10)
                    ->once()
                    ->andReturn(true);

                $mock->shouldReceive('provider')
                    ->once()
                    ->andReturn($provider);
            })
        );

        $this->postJson('/api/network/hotspot/hotspot01/disconnect', [
            'device_id' => 10,
        ])
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);
    }
}
