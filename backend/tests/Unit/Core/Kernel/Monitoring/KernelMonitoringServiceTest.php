<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Monitoring;

use App\Core\Kernel\Monitoring\KernelBootMetric;
use App\Core\Kernel\Monitoring\KernelBootReport;
use App\Core\Kernel\Monitoring\KernelBootStage;
use App\Core\Kernel\Monitoring\KernelBootTimeline;
use App\Core\Kernel\Monitoring\KernelMonitoringService;
use PHPUnit\Framework\TestCase;

final class KernelMonitoringServiceTest extends TestCase
{
    public function test_report_contains_timeline_metrics_and_total(): void
    {
        $timeline = new KernelBootTimeline();

        $timeline->start();

        $timeline->record(
            KernelBootStage::Discovery,
            microtime(true),
        );

        $timeline->record(
            KernelBootStage::Validation,
            microtime(true),
        );

        $service = new KernelMonitoringService(
            $timeline,
        );

        $report = $service->report();

        self::assertInstanceOf(
            KernelBootReport::class,
            $report,
        );

        self::assertCount(
            2,
            $report->metrics(),
        );

        self::assertSame(
            KernelBootStage::Discovery,
            $report->metrics()[0]->stage(),
        );

        self::assertSame(
            KernelBootStage::Validation,
            $report->metrics()[1]->stage(),
        );

        self::assertGreaterThanOrEqual(
            0.0,
            $report->total(),
        );
    }

    public function test_report_exposes_total_in_milliseconds(): void
    {
        $timeline = new KernelBootTimeline();

        $timeline->start();

        $service = new KernelMonitoringService(
            $timeline,
        );

        $report = $service->report();

        self::assertSame(
            $report->total() * 1000,
            $report->totalMilliseconds(),
        );
    }

    public function test_report_preserves_metric_objects(): void
    {
        $timeline = new KernelBootTimeline();

        $timeline->start();

        $timeline->record(
            KernelBootStage::Compilation,
            microtime(true),
        );

        $originalMetric = $timeline->metrics()[0];

        $service = new KernelMonitoringService(
            $timeline,
        );

        $report = $service->report();

        self::assertSame(
            $originalMetric,
            $report->metrics()[0],
        );

        self::assertInstanceOf(
            KernelBootMetric::class,
            $report->metrics()[0],
        );
    }
}
