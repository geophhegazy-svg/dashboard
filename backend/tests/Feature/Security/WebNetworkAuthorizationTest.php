<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class WebNetworkAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function userWithoutPermissions(): User
    {
        $user = User::factory()->create();

        $user->syncRoles([]);

        return $user;
    }

    private function userWithPermission(string $permission): User
    {
        $user = User::factory()->create();

        $permissionModel = Permission::findOrCreate(
            $permission,
            'web'
        );

        $user->givePermissionTo($permissionModel);

        return $user;
    }

    public function test_unauthenticated_web_network_routes_require_authentication(): void
    {
        $routes = [
            ['GET', '/queues'],
            ['GET', '/queues/create'],
            ['POST', '/queues'],
            ['POST', '/queues/test/toggle'],
            ['DELETE', '/queues/test'],
            ['GET', '/queues/test/edit'],
            ['PUT', '/queues/test'],

            ['GET', '/firewall'],
            ['GET', '/firewall/create'],
            ['POST', '/firewall'],
            ['DELETE', '/firewall/test'],
            ['GET', '/firewall/test/edit'],
            ['PUT', '/firewall/test'],

            ['GET', '/dhcp'],
            ['GET', '/dhcp/create'],
            ['POST', '/dhcp'],
            ['PUT', '/dhcp/test'],
            ['DELETE', '/dhcp/test'],
            ['GET', '/dhcp/test/edit'],
        ];

        foreach ($routes as [$method, $uri]) {
            $response = $this->call($method, $uri);

            $this->assertSame(
                302,
                $response->getStatusCode(),
                "{$method} {$uri} must require authentication."
            );
        }
    }

    public function test_queue_routes_require_their_independent_permissions(): void
    {
        $routes = [
            ['GET', '/queues', 'queue.view'],
            ['GET', '/queues/create', 'queue.create'],
            ['POST', '/queues', 'queue.create'],
            ['POST', '/queues/test/toggle', 'queue.toggle'],
            ['DELETE', '/queues/test', 'queue.delete'],
            ['GET', '/queues/test/edit', 'queue.update'],
            ['PUT', '/queues/test', 'queue.update'],
        ];

        $this->assertPermissionDenied($routes);
    }

    public function test_firewall_routes_require_their_independent_permissions(): void
    {
        $routes = [
            ['GET', '/firewall', 'firewall.view'],
            ['GET', '/firewall/create', 'firewall.create'],
            ['POST', '/firewall', 'firewall.create'],
            ['DELETE', '/firewall/test', 'firewall.delete'],
            ['GET', '/firewall/test/edit', 'firewall.update'],
            ['PUT', '/firewall/test', 'firewall.update'],
        ];

        $this->assertPermissionDenied($routes);
    }

    public function test_dhcp_routes_require_their_independent_permissions(): void
    {
        $routes = [
            ['GET', '/dhcp', 'dhcp.view'],
            ['GET', '/dhcp/create', 'dhcp.create'],
            ['POST', '/dhcp', 'dhcp.create'],
            ['PUT', '/dhcp/test', 'dhcp.update'],
            ['DELETE', '/dhcp/test', 'dhcp.delete'],
            ['GET', '/dhcp/test/edit', 'dhcp.update'],
        ];

        $this->assertPermissionDenied($routes);
    }

    private function assertPermissionDenied(array $routes): void
    {
        foreach ($routes as [$method, $uri, $permission]) {
            $user = $this->userWithoutPermissions();

            $this->actingAs($user);

            $response = $this->call($method, $uri);

            $this->assertSame(
                403,
                $response->getStatusCode(),
                "{$method} {$uri} must require {$permission}."
            );
        }
    }

    public function test_queue_permissions_are_independent_from_mikrotik_view(): void
    {
        $user = $this->userWithPermission('mikrotik.view');

        $this->actingAs($user);

        $this->get('/queues')
            ->assertForbidden();
    }

    public function test_firewall_permissions_are_independent_from_mikrotik_view(): void
    {
        $user = $this->userWithPermission('mikrotik.view');

        $this->actingAs($user);

        $this->get('/firewall')
            ->assertForbidden();
    }

    public function test_dhcp_permissions_are_independent_from_mikrotik_view(): void
    {
        $user = $this->userWithPermission('mikrotik.view');

        $this->actingAs($user);

        $this->get('/dhcp')
            ->assertForbidden();
    }
}
