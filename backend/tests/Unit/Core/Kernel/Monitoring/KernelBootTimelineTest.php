<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Monitoring;

use App\Core\Kernel\Monitoring\KernelBootStage;
use App\Core\Kernel\Monitoring\KernelBootTimeline;
use PHPUnit\Framework\TestCase;

final class KernelBootTimelineTest extends TestCase
{
    public function test_total_is_zero_before_start(): void
    {
        $timeline = new KernelBootTimeline();

        self::assertSame(
            0.0,
            $timeline->total(),
        );
    }

    public function test_start_initializes_total_measurement(): void
    {
        $timeline = new KernelBootTimeline();

        $timeline->start();

        self::assertGreaterThanOrEqual(
            0.0,
            $timeline->total(),
        );
    }

    public function test_record_creates_metric_for_stage(): void
    {
        $timeline = new KernelBootTimeline();

        $timeline->start();

        $started = microtime(true);

        usleep(1000);

        $timeline->record(
            KernelBootStage::Discovery,
            $started,
        );

        $metrics = $timeline->metrics();

        self::assertCount(1, $metrics);
        self::assertSame(
            KernelBootStage::Discovery,
            $metrics[0]->stage(),
        );
        self::assertGreaterThanOrEqual(
            0.0,
            $metrics[0]->duration(),
        );
    }

    public function test_metrics_preserve_boot_stage_order(): void
    {
        $timeline = new KernelBootTimeline();

        $timeline->start();

        foreach (KernelBootStage::cases() as $stage) {
            $timeline->record(
                $stage,
                microtime(true),
            );
        }

        self::assertSame(
            KernelBootStage::cases(),
            array_map(
                static fn ($metric): KernelBootStage => $metric->stage(),
                $timeline->metrics(),
            ),
        );
    }
}
