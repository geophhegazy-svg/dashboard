<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Models\User;
use App\Modules\Reports\Application\Actions\ActivateScheduledReportAction;
use App\Modules\Reports\Application\Actions\CreateScheduledReportAction;
use App\Modules\Reports\Application\Actions\DeactivateScheduledReportAction;
use App\Modules\Reports\Application\Actions\DeleteScheduledReportAction;
use App\Modules\Reports\Application\Actions\UpdateScheduledReportAction;
use App\Modules\Reports\Application\Actions\UpdateScheduledReportLastRunAction;
use App\Modules\Reports\Application\Actions\UpdateScheduledReportNextRunAction;
use App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduledReportActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_scheduled_report_can_be_created(): void
    {
        $user = User::factory()->create();

        $report = app(CreateScheduledReportAction::class)->execute([
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

        $updated = app(UpdateScheduledReportAction::class)->execute(
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

    public function test_scheduled_report_can_be_deleted(): void
    {
        $report = ScheduledReport::factory()->create();

        $result = app(DeleteScheduledReportAction::class)->execute(
            $report
        );

        $this->assertTrue($result);

        $this->assertDatabaseMissing(
            'scheduled_reports',
            [
                'id' => $report->id,
            ]
        );
    }

    public function test_scheduled_report_can_be_activated(): void
    {
        $report = ScheduledReport::factory()->create([
            'is_active' => false,
        ]);

        $updated = app(ActivateScheduledReportAction::class)->execute(
            $report
        );

        $this->assertTrue(
            $updated->is_active
        );
    }

    public function test_scheduled_report_can_be_deactivated(): void
    {
        $report = ScheduledReport::factory()->create([
            'is_active' => true,
        ]);

        $updated = app(DeactivateScheduledReportAction::class)->execute(
            $report
        );

        $this->assertFalse(
            $updated->is_active
        );
    }

    public function test_last_run_can_be_updated(): void
    {
        $report = ScheduledReport::factory()->create([
            'last_run_at' => null,
        ]);

        $updated = app(
            UpdateScheduledReportLastRunAction::class
        )->execute($report);

        $this->assertNotNull(
            $updated->last_run_at
        );
    }

    public function test_next_run_can_be_updated(): void
    {
        $report = ScheduledReport::factory()->create([
            'next_run_at' => null,
        ]);

        $nextRun = Carbon::now()->addWeek();

        $updated = app(
            UpdateScheduledReportNextRunAction::class
        )->execute(
            $report,
            $nextRun
        );

        $this->assertNotNull(
            $updated->next_run_at
        );

        $this->assertEquals(
            $nextRun->timestamp,
            $updated->next_run_at->timestamp
        );
    }
}
