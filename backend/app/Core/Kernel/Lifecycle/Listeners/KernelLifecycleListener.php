<?php

declare(strict_types=1);

namespace App\Core\Kernel\Lifecycle\Listeners;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Core\Kernel\Lifecycle\Events\KernelFailed;
use App\Core\Kernel\Lifecycle\Events\KernelStarted;
use App\Core\Kernel\Lifecycle\Events\KernelStarting;
use App\Core\Kernel\Lifecycle\Events\KernelStopping;
use App\Core\Kernel\Lifecycle\Events\KernelStopped;

final readonly class KernelLifecycleListener
implements EventListenerInterface
{
    public function handle(
        EventContract $event,
    ): void {

        match (true) {

            $event instanceof KernelStarting =>
            $this->onStarting(),

            $event instanceof KernelStarted =>
            $this->onStarted(),

            $event instanceof KernelFailed =>
            $this->onFailed(),

            $event instanceof KernelStopping =>
            $this->onStopping(),

            $event instanceof KernelStopped =>
            $this->onStopped(),

            default => null,
        };
    }


    private function onStarting(): void
    {
        // reserved for lifecycle metrics
    }


    private function onStarted(): void
    {
        // reserved for lifecycle metrics
    }


    private function onFailed(): void
    {
        // reserved for failure metrics
    }


    private function onStopping(): void
    {
        // reserved for lifecycle metrics
    }


    private function onStopped(): void
    {
        // reserved for lifecycle metrics
    }
}
