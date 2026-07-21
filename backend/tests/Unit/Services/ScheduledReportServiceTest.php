<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\ScheduledReport;
use App\Models\User;
use App\Modules\Reports\ScheduledReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduledReportServiceTest extends TestCase
{
    use RefreshDatabase;

    private ScheduledReportService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(ScheduledReportService::class);
    }

    public function test_scheduled_report_can_be_created(): void
    {
        $user = User::factory()->create();

        $report = $this->service->create([
            'name' => 'Daily Customers',
            'report_name' => 'customers',
            'frequency' => 'daily',
            'format' => 'csv',
            'created_by' => $user->id,
        ]);

        $this->assertInstanceOf(
            ScheduledReport::class,
            $report
        );

        $this->assertDatabaseHas('scheduled_reports', [
            'id' => $report->id,
            'name' => 'Daily Customers',
        ]);
    }

    public function test_scheduled_report_can_be_updated(): void
    {
        $report = ScheduledReport::factory()->create();

        $updated = $this->service->update(
            $report,
            [
                'name' => 'Weekly Customers',
            ]
        );

        $this->assertEquals(
            'Weekly Customers',
            $updated->name
        );
    }

    public function test_scheduled_report_can_be_activated(): void
    {
        $report = ScheduledReport::factory()->create([
            'is_active' => false,
        ]);

        $updated = $this->service->activate($report);

        $this->assertTrue(
            $updated->is_active
        );
    }

    public function test_scheduled_report_can_be_deactivated(): void
    {
        $report = ScheduledReport::factory()->create([
            'is_active' => true,
        ]);

        $updated = $this->service->deactivate($report);

        $this->assertFalse(
            $updated->is_active
        );
    }

    public function test_last_run_can_be_updated(): void
    {
        $report = ScheduledReport::factory()->create();

        $updated = $this->service->updateLastRun($report);

        $this->assertNotNull(
            $updated->last_run_at
        );
    }
}
