<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Contract;

use App\Models\User;
use App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\Fakes\FakeMikrotikService;
use Tests\TestCase;

final class ApiResponseContractTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(
            MikrotikServiceInterface::class,
            new FakeMikrotikService()
        );
    }

    private function authenticateUser(array $permissions = []): User
    {
        $user = User::factory()->create();

        foreach ($permissions as $permission) {
            $permissionModel = Permission::findOrCreate($permission, 'web');
            $user->givePermissionTo($permissionModel);
        }

        Sanctum::actingAs($user);

        return $user;
    }

    public function test_lifecycle_endpoints_use_the_established_envelope(): void
    {
        $this->authenticateUser([
            'subscriptions.activate',
        ]);

        $subscription = Subscription::factory()
            ->suspended()
            ->create();

        $response = $this->postJson(
            "/api/subscriptions/{$subscription->id}/activate"
        );

        $response
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ])
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $subscription->id)
            ->assertJsonPath('data.status', 'active');
    }

    public function test_paginated_resource_endpoints_preserve_resource_and_pagination_contract(): void
    {
        $user = $this->authenticateUser();

        $user->assignRole('Super Admin');

        ScheduledReport::factory()
            ->count(3)
            ->create();

        $response = $this->getJson('/api/scheduled-reports');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ])
            ->assertJsonPath('meta.current_page', 1)
            ->assertJsonPath('meta.per_page', 15);
    }

    public function test_dashboard_metric_endpoints_use_their_dedicated_payload_shape(): void
    {
        $this->authenticateUser([
            'dashboard.statistics',
        ]);

        $this->getJson('/api/dashboard/stats')
            ->assertOk()
            ->assertJsonStructure([
                'totalUsers',
                'onlineUsers',
                'totalDevices',
                'onlineDevices',
            ]);
    }

    public function test_authenticated_user_login_uses_the_token_user_contract(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertOk()
            ->assertJsonStructure([
                'token',
                'user',
            ])
            ->assertJsonPath('user.id', $user->id);
    }

    public function test_no_content_endpoints_remain_no_content(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Super Admin');

        Sanctum::actingAs($user);

        $report = ScheduledReport::factory()->create();

        $this->deleteJson(
            "/api/scheduled-reports/{$report->id}"
        )->assertNoContent();
    }
}
