<?php

declare(strict_types=1);

namespace App\Core\Kernel\Shutdown;

use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Kernel\Contracts\KernelShutdownManagerInterface;
use App\Core\Kernel\Lifecycle\Events\KernelStopped;
use App\Core\Kernel\Lifecycle\Events\KernelStopping;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use App\Core\Kernel\Runtime\KernelRuntimeState;

final readonly class KernelShutdownManager implements KernelShutdownManagerInterface
{
    public function __construct(
        private KernelLifecycleManager $lifecycle,
        private KernelRuntimeState $runtime,
        private EventDispatcherInterface $events,
    ) {}

    public function shutdown(): void
    {
        $state = $this->lifecycle->state();

        if ($state === KernelLifecycleState::Stopped) {
            return;
        }

        if ($state === KernelLifecycleState::Failed) {
            $this->runtime->reset();

            $this->lifecycle->transition(
                KernelLifecycleState::Stopped,
            );

            $this->events->dispatch(
                new KernelStopped(
                    KernelLifecycleState::Stopped,
                ),
            );

            return;
        }

        if ($state !== KernelLifecycleState::Ready) {
            return;
        }

        $this->lifecycle->transition(
            KernelLifecycleState::Stopping,
        );

        $this->events->dispatch(
            new KernelStopping(
                KernelLifecycleState::Stopping,
            ),
        );

        $this->runtime->reset();

        $this->lifecycle->transition(
            KernelLifecycleState::Stopped,
        );

        $this->events->dispatch(
            new KernelStopped(
                KernelLifecycleState::Stopped,
            ),
        );
    }
}
