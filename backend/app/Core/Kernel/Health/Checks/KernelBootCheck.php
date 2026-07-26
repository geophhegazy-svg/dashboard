<?php

declare(strict_types=1);

namespace App\Core\Kernel\Health\Checks;

use App\Core\Kernel\Health\Contracts\KernelHealthCheckInterface;
use App\Core\Kernel\Health\KernelHealthResult;
use App\Core\Kernel\Runtime\KernelRuntimeState;

final readonly class KernelBootCheck
implements KernelHealthCheckInterface
{
    public function __construct(
        private KernelRuntimeState $runtime,
    ) {}


    public function name(): string
    {
        return 'Kernel Boot';
    }


    public function check(): KernelHealthResult
    {
        if (! $this->runtime->isBooted()) {

            return new KernelHealthResult(
                $this->name(),
                false,
                'Kernel runtime context is missing.',
            );
        }


        return new KernelHealthResult(
            $this->name(),
            true,
            'Kernel is booted successfully.',
        );
    }
}
