<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Kernel;

use App\Core\Kernel\Contracts\KernelCommandRegistrarInterface;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;

final readonly class LaravelKernelCommandRegistrar implements KernelCommandRegistrarInterface
{
    public function __construct(
        private ConsoleKernel $kernel,
    ) {}

    public function register(
        string $command,
    ): void {
        $this->kernel->addCommands([
            $command,
        ]);
    }
}
