<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ScheduledReport;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduledReportControllerTest extends TestCase
{
    use RefreshDatabase;

    private function login(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Super Admin');

        Sanctum::actingAs($user);
    }

    public function test_index_returns_reports(): void
    {
        $this->login();

        ScheduledReport::factory()
            ->count(3)
            ->create();

        $this->getJson('/api/scheduled-reports')
            ->assertOk();
    }

    public function test_store_creates_report(): void
    {
        $this->login();

        $user = User::factory()->create();

        $this->postJson('/api/scheduled-reports', [
            'name' => 'Daily Customers',
            'report_name' => 'customers',
            'frequency' => 'daily',
            'format' => 'csv',
            'created_by' => $user->id,
        ])
            ->assertCreated();

        $this->assertDatabaseHas(
            'scheduled_reports',
            [
                'name' => 'Daily Customers',
            ]
        );
    }

    public function test_update_report(): void
    {
        $this->login();

        $report = ScheduledReport::factory()->create();

        $this->putJson(
            "/api/scheduled-reports/{$report->id}",
            [
                'name' => 'Updated Report',
                'report_name' => $report->report_name,
                'frequency' => $report->frequency,
                'format' => $report->format,
            ]
        )->assertOk();

        $this->assertDatabaseHas(
            'scheduled_reports',
            [
                'id' => $report->id,
                'name' => 'Updated Report',
            ]
        );
    }

    public function test_delete_report(): void
    {
        $this->login();

        $report = ScheduledReport::factory()->create();

        $this->deleteJson(
            "/api/scheduled-reports/{$report->id}"
        )->assertNoContent();

        $this->assertDatabaseMissing(
            'scheduled_reports',
            [
                'id' => $report->id,
            ]
        );
    }
}
