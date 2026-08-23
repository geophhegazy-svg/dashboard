<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Health;

use App\Core\Kernel\Health\KernelHealthReport;
use App\Core\Kernel\Health\KernelHealthResult;
use PHPUnit\Framework\TestCase;

final class KernelHealthReportTest extends TestCase
{
    public function test_report_is_healthy_when_all_results_pass(): void
    {
        $results = [
            new KernelHealthResult(
                name: 'Kernel Boot',
                passed: true,
                message: 'Kernel is booted successfully.',
            ),
            new KernelHealthResult(
                name: 'Manifest Availability',
                passed: true,
                message: 'Manifest is available.',
            ),
        ];

        $report = new KernelHealthReport($results);

        self::assertTrue($report->healthy());
        self::assertSame('HEALTHY', $report->status());
        self::assertSame($results, $report->results());
    }

    public function test_report_is_failed_when_any_result_fails(): void
    {
        $results = [
            new KernelHealthResult(
                name: 'Kernel Boot',
                passed: true,
                message: 'Kernel is booted successfully.',
            ),
            new KernelHealthResult(
                name: 'Manifest Availability',
                passed: false,
                message: 'Manifest is missing.',
            ),
        ];

        $report = new KernelHealthReport($results);

        self::assertFalse($report->healthy());
        self::assertSame('FAILED', $report->status());
        self::assertSame($results, $report->results());
    }

    public function test_empty_report_is_healthy(): void
    {
        $report = new KernelHealthReport([]);

        self::assertTrue($report->healthy());
        self::assertSame('HEALTHY', $report->status());
        self::assertSame([], $report->results());
    }
}
