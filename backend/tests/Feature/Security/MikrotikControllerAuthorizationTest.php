<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\PppoeServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

final class MikrotikControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function userWithoutPermission(): User
    {
        return User::factory()->create();
    }

    private function userWithPermission(string $permission): User
    {
        $user = User::factory()->create();

        $user->givePermissionTo($permission);

        return $user;
    }

    public function test_mikrotik_test_requires_view_permission(): void
    {
        $user = $this->userWithoutPermission();

        Sanctum::actingAs($user);

        $this->getJson('/api/mikrotik/test')
            ->assertForbidden();
    }

    public function test_mikrotik_test_allows_view_permission(): void
    {
        $user = $this->userWithPermission('mikrotik.view');

        Sanctum::actingAs($user);

        $this->mockNetworkProvider();

        $this->getJson('/api/mikrotik/test')
            ->assertStatus(200);
    }

    public function test_pppoe_users_require_view_permission(): void
    {
        $user = $this->userWithoutPermission();

        Sanctum::actingAs($user);

        $this->getJson('/api/mikrotik/pppoe-users')
            ->assertForbidden();
    }

    public function test_pppoe_users_allow_view_permission(): void
    {
        $user = $this->userWithPermission('mikrotik.pppoe.view');

        Sanctum::actingAs($user);

        $this->mockNetworkProvider('pppoe');

        $this->getJson('/api/mikrotik/pppoe-users')
            ->assertOk();
    }

    public function test_hotspot_users_require_view_permission(): void
    {
        $user = $this->userWithoutPermission();

        Sanctum::actingAs($user);

        $this->getJson('/api/mikrotik/hotspot-users')
            ->assertForbidden();
    }

    public function test_hotspot_users_allow_view_permission(): void
    {
        $user = $this->userWithPermission('mikrotik.hotspot.view');

        Sanctum::actingAs($user);

        $this->mockNetworkProvider('hotspot');

        $this->getJson('/api/mikrotik/hotspot-users')
            ->assertOk();
    }

    private function mockNetworkProvider(?string $service = null): void
    {
        $device = new NetworkDevice();
        $device->id = 1;

        $this->app->instance(
            NetworkDeviceRepositoryInterface::class,
            Mockery::mock(NetworkDeviceRepositoryInterface::class, function ($mock) use ($device): void {
                $mock->shouldReceive('find')
                    ->with(1)
                    ->once()
                    ->andReturn($device);
            })
        );

        $provider = Mockery::mock(NetworkProviderInterface::class);

        if ($service === 'pppoe') {
            $pppoe = Mockery::mock(PppoeServiceInterface::class);

            $pppoe->shouldReceive('getAllUsers')
                ->once()
                ->andReturn([]);

            $provider->shouldReceive('pppoe')
                ->once()
                ->andReturn($pppoe);
        }

        if ($service === 'hotspot') {
            $hotspot = Mockery::mock(HotspotServiceInterface::class);

            $hotspot->shouldReceive('getUsers')
                ->once()
                ->andReturn([]);

            $provider->shouldReceive('hotspot')
                ->once()
                ->andReturn($hotspot);
        }

        $this->app->instance(
            NetworkManagerInterface::class,
            Mockery::mock(NetworkManagerInterface::class, function ($mock) use ($provider): void {
                $mock->shouldReceive('connect')
                    ->with(1)
                    ->once()
                    ->andReturn(true);

                $mock->shouldReceive('provider')
                    ->once()
                    ->andReturn($provider);
            })
        );
    }
}
