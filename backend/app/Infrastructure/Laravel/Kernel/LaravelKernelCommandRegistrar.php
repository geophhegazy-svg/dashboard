<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Kernel;

use App\Core\Kernel\Contracts\KernelCommandRegistrarInterface;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use ReflectionClass;

final readonly class LaravelKernelCommandRegistrar
implements KernelCommandRegistrarInterface
{
    public function __construct(
        private ConsoleKernel $kernel,
    ) {}

    public function register(
        string $command,
    ): void {

        $reflection = new ReflectionClass(
            $this->kernel,
        );

        $property = $reflection->getProperty(
            'commands',
        );

        $property->setAccessible(true);

        $commands = $property->getValue(
            $this->kernel,
        );

        $commands[] = $command;

        $property->setValue(
            $this->kernel,
            array_unique($commands),
        );
    }
}
