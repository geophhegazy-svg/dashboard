<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel\Health;

use App\Core\Kernel\Health\Checks\KernelBootCheck;
use App\Core\Kernel\Health\Checks\KernelLifecycleCheck;
use App\Core\Kernel\Health\Checks\ManifestAvailabilityCheck;
use App\Core\Kernel\Health\KernelHealthService;
use Tests\TestCase;

final class KernelHealthServiceProviderTest extends TestCase
{
    public function test_kernel_health_service_is_registered_as_singleton(): void
    {
        $first = $this->app->make(
            KernelHealthService::class,
        );

        $second = $this->app->make(
            KernelHealthService::class,
        );

        self::assertInstanceOf(
            KernelHealthService::class,
            $first,
        );

        self::assertSame(
            $first,
            $second,
        );
    }

    public function test_kernel_health_checks_are_registered_as_singletons(): void
    {
        $bootFirst = $this->app->make(
            KernelBootCheck::class,
        );

        $bootSecond = $this->app->make(
            KernelBootCheck::class,
        );

        self::assertSame(
            $bootFirst,
            $bootSecond,
        );

        $manifestFirst = $this->app->make(
            ManifestAvailabilityCheck::class,
        );

        $manifestSecond = $this->app->make(
            ManifestAvailabilityCheck::class,
        );

        self::assertSame(
            $manifestFirst,
            $manifestSecond,
        );

        $lifecycleFirst = $this->app->make(
            KernelLifecycleCheck::class,
        );

        $lifecycleSecond = $this->app->make(
            KernelLifecycleCheck::class,
        );

        self::assertSame(
            $lifecycleFirst,
            $lifecycleSecond,
        );
    }

    public function test_kernel_health_service_is_operational_through_container(): void
    {
        $service = $this->app->make(
            KernelHealthService::class,
        );

        $report = $service->check();

        self::assertTrue(
            $report->healthy(),
        );

        self::assertSame(
            'HEALTHY',
            $report->status(),
        );

        self::assertCount(
            3,
            $report->results(),
        );

        self::assertSame(
            [
                'Kernel Boot',
                'Manifest',
                'Kernel Lifecycle',
            ],
            array_map(
                static fn ($result): string => $result->name(),
                $report->results(),
            ),
        );
    }
}
