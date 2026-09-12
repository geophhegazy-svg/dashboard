<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class ReportControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_report_requires_permission(): void
    {
        $this->assertReportEndpointRequiresPermission(
            '/api/reports/dashboard',
            'reports.dashboard',
        );
    }

    public function test_dashboard_report_allows_matching_permission(): void
    {
        $this->assertReportEndpointAllowsPermission(
            '/api/reports/dashboard',
            'reports.dashboard',
        );
    }

    public function test_revenue_report_requires_permission(): void
    {
        $this->assertReportEndpointRequiresPermission(
            '/api/reports/revenue',
            'reports.revenue',
        );
    }

    public function test_revenue_report_allows_matching_permission(): void
    {
        $this->assertReportEndpointAllowsPermission(
            '/api/reports/revenue',
            'reports.revenue',
        );
    }

    public function test_inventory_report_requires_permission(): void
    {
        $this->assertReportEndpointRequiresPermission(
            '/api/reports/inventory',
            'reports.inventory',
        );
    }

    public function test_inventory_report_allows_matching_permission(): void
    {
        $this->assertReportEndpointAllowsPermission(
            '/api/reports/inventory',
            'reports.inventory',
        );
    }

    public function test_invoices_report_requires_permission(): void
    {
        $this->assertReportEndpointRequiresPermission(
            '/api/reports/invoices',
            'reports.invoices',
        );
    }

    public function test_invoices_report_allows_matching_permission(): void
    {
        $this->assertReportEndpointAllowsPermission(
            '/api/reports/invoices',
            'reports.invoices',
        );
    }

    public function test_tickets_report_requires_permission(): void
    {
        $this->assertReportEndpointRequiresPermission(
            '/api/reports/tickets',
            'reports.tickets',
        );
    }

    public function test_tickets_report_allows_matching_permission(): void
    {
        $this->assertReportEndpointAllowsPermission(
            '/api/reports/tickets',
            'reports.tickets',
        );
    }

    private function assertReportEndpointRequiresPermission(
        string $uri,
        string $permission,
    ): void {
        $user = User::factory()->create();

        Permission::findOrCreate($permission, 'web');

        $this->actingAs($user, 'sanctum')
            ->getJson($uri)
            ->assertForbidden();
    }

    private function assertReportEndpointAllowsPermission(
        string $uri,
        string $permission,
    ): void {
        $user = User::factory()->create();

        $permissionModel = Permission::findOrCreate($permission, 'web');
        $user->givePermissionTo($permissionModel);

        $this->actingAs($user, 'sanctum')
            ->getJson($uri)
            ->assertOk();
    }
}
