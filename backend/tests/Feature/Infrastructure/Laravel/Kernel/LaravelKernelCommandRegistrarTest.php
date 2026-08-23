<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Laravel\Kernel;

use App\Core\Kernel\Contracts\KernelCommandRegistrarInterface;
use App\Infrastructure\Laravel\Kernel\LaravelKernelCommandRegistrar;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use ReflectionClass;
use Tests\TestCase;

final class LaravelKernelCommandRegistrarTest extends TestCase
{
    public function test_registrar_is_bound_to_kernel_command_registrar_contract(): void
    {
        $registrar = $this->app->make(
            KernelCommandRegistrarInterface::class,
        );

        self::assertInstanceOf(
            LaravelKernelCommandRegistrar::class,
            $registrar,
        );
    }

    public function test_register_adds_command_to_console_kernel(): void
    {
        $registrar = $this->app->make(
            KernelCommandRegistrarInterface::class,
        );

        $command = 'test:kernel-registrar';

        $registrar->register($command);

        $kernel = $this->app->make(
            ConsoleKernel::class,
        );

        $reflection = new ReflectionClass($kernel);

        $property = $reflection->getProperty(
            'commands',
        );

        $property->setAccessible(true);

        $commands = $property->getValue(
            $kernel,
        );

        self::assertContains(
            $command,
            $commands,
        );
    }

    public function test_register_does_not_duplicate_command(): void
    {
        $registrar = $this->app->make(
            KernelCommandRegistrarInterface::class,
        );

        $command = 'test:kernel-registrar-unique';

        $registrar->register($command);
        $registrar->register($command);

        $kernel = $this->app->make(
            ConsoleKernel::class,
        );

        $reflection = new ReflectionClass($kernel);

        $property = $reflection->getProperty(
            'commands',
        );

        $property->setAccessible(true);

        $commands = $property->getValue(
            $kernel,
        );

        self::assertSame(
            1,
            count(
                array_filter(
                    $commands,
                    static fn (string $registered): bool =>
                        $registered === $command,
                ),
            ),
        );
    }
}
