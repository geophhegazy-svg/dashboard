<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Health\Contracts\KernelHealthCheckInterface;
use App\Core\Kernel\Health\KernelHealthResult;
use App\Core\Kernel\Health\KernelHealthService;
use App\Infrastructure\Laravel\Console\Kernel\KernelHealthCommand;
use Illuminate\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

final class KernelHealthCommandTest extends TestCase
{
    public function test_command_returns_success_when_kernel_is_healthy(): void
    {
        $service = new KernelHealthService([
            new class implements KernelHealthCheckInterface {
                public function name(): string
                {
                    return 'Kernel Boot';
                }

                public function check(): KernelHealthResult
                {
                    return new KernelHealthResult(
                        name: $this->name(),
                        passed: true,
                        message: 'Kernel is booted successfully.',
                    );
                }
            },

            new class implements KernelHealthCheckInterface {
                public function name(): string
                {
                    return 'Manifest';
                }

                public function check(): KernelHealthResult
                {
                    return new KernelHealthResult(
                        name: $this->name(),
                        passed: true,
                        message: 'Manifest loaded (17 modules).',
                    );
                }
            },
        ]);

        $this->app->instance(
            KernelHealthService::class,
            $service,
        );

        $command = $this->app->make(
            KernelHealthCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester($application->find('kernel:health'));

        $exitCode = $tester->execute([]);

        self::assertSame(0, $exitCode);

        $output = $tester->getDisplay();

        self::assertStringContainsString(
            'Kernel Health',
            $output,
        );

        self::assertStringContainsString(
            'STATUS: HEALTHY',
            $output,
        );

        self::assertStringContainsString(
            '✓ Kernel Boot',
            $output,
        );

        self::assertStringContainsString(
            '✓ Manifest',
            $output,
        );

        self::assertStringContainsString(
            'Kernel is booted successfully.',
            $output,
        );

        self::assertStringContainsString(
            'Manifest loaded (17 modules).',
            $output,
        );
    }

    public function test_command_returns_failure_when_kernel_health_fails(): void
    {
        $service = new KernelHealthService([
            new class implements KernelHealthCheckInterface {
                public function name(): string
                {
                    return 'Kernel Boot';
                }

                public function check(): KernelHealthResult
                {
                    return new KernelHealthResult(
                        name: $this->name(),
                        passed: false,
                        message: 'Kernel runtime context is missing.',
                    );
                }
            },

            new class implements KernelHealthCheckInterface {
                public function name(): string
                {
                    return 'Manifest';
                }

                public function check(): KernelHealthResult
                {
                    return new KernelHealthResult(
                        name: $this->name(),
                        passed: true,
                        message: 'Manifest loaded (17 modules).',
                    );
                }
            },
        ]);

        $this->app->instance(
            KernelHealthService::class,
            $service,
        );

        $command = $this->app->make(
            KernelHealthCommand::class,
        );

        $application = new Application(
            $this->app,
            $this->app->make('events'),
            'Testing',
        );

        $application->add($command);

        $tester = new CommandTester($application->find('kernel:health'));

        $exitCode = $tester->execute([]);

        self::assertSame(1, $exitCode);

        $output = $tester->getDisplay();

        self::assertStringContainsString(
            'STATUS: FAILED',
            $output,
        );

        self::assertStringContainsString(
            '✗ Kernel Boot',
            $output,
        );

        self::assertStringContainsString(
            'Kernel runtime context is missing.',
            $output,
        );

        self::assertStringContainsString(
            '✓ Manifest',
            $output,
        );
    }
}
