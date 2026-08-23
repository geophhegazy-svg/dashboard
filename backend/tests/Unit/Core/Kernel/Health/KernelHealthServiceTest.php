<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Health;

use App\Core\Kernel\Health\Contracts\KernelHealthCheckInterface;
use App\Core\Kernel\Health\KernelHealthResult;
use App\Core\Kernel\Health\KernelHealthService;
use PHPUnit\Framework\TestCase;

final class KernelHealthServiceTest extends TestCase
{
    public function test_service_executes_all_checks_and_preserves_order(): void
    {
        $first = new KernelHealthResult(
            name: 'First Check',
            passed: true,
            message: 'First passed.',
        );

        $second = new KernelHealthResult(
            name: 'Second Check',
            passed: false,
            message: 'Second failed.',
        );

        $firstCheck = $this->createMock(
            KernelHealthCheckInterface::class,
        );

        $firstCheck
            ->expects(self::once())
            ->method('check')
            ->willReturn($first);

        $secondCheck = $this->createMock(
            KernelHealthCheckInterface::class,
        );

        $secondCheck
            ->expects(self::once())
            ->method('check')
            ->willReturn($second);

        $service = new KernelHealthService([
            $firstCheck,
            $secondCheck,
        ]);

        $report = $service->check();

        self::assertSame(
            [$first, $second],
            $report->results(),
        );

        self::assertFalse($report->healthy());
        self::assertSame('FAILED', $report->status());
    }

    public function test_service_returns_healthy_report_when_all_checks_pass(): void
    {
        $first = new KernelHealthResult(
            name: 'First Check',
            passed: true,
            message: 'First passed.',
        );

        $second = new KernelHealthResult(
            name: 'Second Check',
            passed: true,
            message: 'Second passed.',
        );

        $firstCheck = $this->createMock(
            KernelHealthCheckInterface::class,
        );

        $firstCheck
            ->expects(self::once())
            ->method('check')
            ->willReturn($first);

        $secondCheck = $this->createMock(
            KernelHealthCheckInterface::class,
        );

        $secondCheck
            ->expects(self::once())
            ->method('check')
            ->willReturn($second);

        $service = new KernelHealthService([
            $firstCheck,
            $secondCheck,
        ]);

        $report = $service->check();

        self::assertTrue($report->healthy());
        self::assertSame('HEALTHY', $report->status());
        self::assertSame(
            [$first, $second],
            $report->results(),
        );
    }
}
