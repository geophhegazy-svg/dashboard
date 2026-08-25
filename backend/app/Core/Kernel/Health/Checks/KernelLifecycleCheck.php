<?php

declare(strict_types=1);

namespace App\Core\Kernel\Health\Checks;

use App\Core\Kernel\Health\Contracts\KernelHealthCheckInterface;
use App\Core\Kernel\Health\KernelHealthResult;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;

final readonly class KernelLifecycleCheck
implements KernelHealthCheckInterface
{
    public function __construct(
        private KernelLifecycleManager $lifecycle,
    ) {}

    public function name(): string
    {
        return 'Kernel Lifecycle';
    }

    public function check(): KernelHealthResult
    {
        $state = $this->lifecycle->state();

        if ($state !== KernelLifecycleState::Ready) {
            return new KernelHealthResult(
                $this->name(),
                false,
                sprintf(
                    'Kernel lifecycle is not ready (state: %s).',
                    $state->value,
                ),
            );
        }

        return new KernelHealthResult(
            $this->name(),
            true,
            'Kernel lifecycle is ready.',
        );
    }
}
