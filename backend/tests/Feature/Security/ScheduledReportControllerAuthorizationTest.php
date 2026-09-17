<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\User;
use App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ScheduledReportControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate(array $permissions = []): User
    {
        $user = User::factory()->create();

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
            $user->givePermissionTo($permission);
        }

        Sanctum::actingAs($user);

        return $user;
    }

    public function test_index_requires_view_permission(): void
    {
        $this->authenticate();

        $this->getJson('/api/scheduled-reports')
            ->assertForbidden();
    }

    public function test_index_allows_view_permission(): void
    {
        $this->authenticate(['scheduled_reports.view']);

        $this->getJson('/api/scheduled-reports')
            ->assertOk();
    }

    public function test_store_requires_create_permission(): void
    {
        $this->authenticate();

        $this->postJson('/api/scheduled-reports', [
            'name' => 'Daily Customers',
            'report_name' => 'customers',
            'frequency' => 'daily',
            'format' => 'csv',
        ])->assertForbidden();
    }

    public function test_store_allows_create_permission(): void
    {
        $this->authenticate(['scheduled_reports.create']);

        $this->postJson('/api/scheduled-reports', [
            'name' => 'Daily Customers',
            'report_name' => 'customers',
            'frequency' => 'daily',
            'format' => 'csv',
        ])->assertCreated();
    }

    public function test_show_requires_view_permission(): void
    {
        $this->authenticate();

        $report = ScheduledReport::factory()->create();

        $this->getJson("/api/scheduled-reports/{$report->id}")
            ->assertForbidden();
    }

    public function test_show_allows_view_permission(): void
    {
        $this->authenticate(['scheduled_reports.view']);

        $report = ScheduledReport::factory()->create();

        $this->getJson("/api/scheduled-reports/{$report->id}")
            ->assertOk();
    }

    public function test_update_requires_update_permission(): void
    {
        $this->authenticate();

        $report = ScheduledReport::factory()->create();

        $this->putJson("/api/scheduled-reports/{$report->id}", [
            'name' => 'Updated Report',
        ])->assertForbidden();
    }

    public function test_update_allows_update_permission(): void
    {
        $this->authenticate(['scheduled_reports.update']);

        $report = ScheduledReport::factory()->create();

        $this->putJson("/api/scheduled-reports/{$report->id}", [
            'name' => 'Updated Report',
        ])->assertOk();
    }

    public function test_delete_requires_delete_permission(): void
    {
        $this->authenticate();

        $report = ScheduledReport::factory()->create();

        $this->deleteJson("/api/scheduled-reports/{$report->id}")
            ->assertForbidden();
    }

    public function test_delete_allows_delete_permission(): void
    {
        $this->authenticate(['scheduled_reports.delete']);

        $report = ScheduledReport::factory()->create();

        $this->deleteJson("/api/scheduled-reports/{$report->id}")
            ->assertNoContent();
    }

    public function test_activate_requires_activate_permission(): void
    {
        $this->authenticate();

        $report = ScheduledReport::factory()->create([
            'is_active' => false,
        ]);

        $this->patchJson(
            "/api/scheduled-reports/{$report->id}/activate"
        )->assertForbidden();
    }

    public function test_activate_allows_activate_permission(): void
    {
        $this->authenticate(['scheduled_reports.activate']);

        $report = ScheduledReport::factory()->create([
            'is_active' => false,
        ]);

        $this->patchJson(
            "/api/scheduled-reports/{$report->id}/activate"
        )->assertOk();
    }

    public function test_deactivate_requires_deactivate_permission(): void
    {
        $this->authenticate();

        $report = ScheduledReport::factory()->create([
            'is_active' => true,
        ]);

        $this->patchJson(
            "/api/scheduled-reports/{$report->id}/deactivate"
        )->assertForbidden();
    }

    public function test_deactivate_allows_deactivate_permission(): void
    {
        $this->authenticate(['scheduled_reports.deactivate']);

        $report = ScheduledReport::factory()->create([
            'is_active' => true,
        ]);

        $this->patchJson(
            "/api/scheduled-reports/{$report->id}/deactivate"
        )->assertOk();
    }

    public function test_accountant_can_view_but_cannot_manage_scheduled_reports(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo(
            Permission::findOrCreate('scheduled_reports.view', 'web')
        );

        Sanctum::actingAs($user);

        $report = ScheduledReport::factory()->create();

        $this->getJson('/api/scheduled-reports')
            ->assertOk();

        $this->deleteJson("/api/scheduled-reports/{$report->id}")
            ->assertForbidden();
    }
}
