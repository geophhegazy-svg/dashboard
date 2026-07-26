<?php

declare(strict_types=1);

namespace App\Core\Kernel\Lifecycle\Registration;

use App\Core\EventBus\EventRegistry;
use App\Core\Kernel\Lifecycle\Events\KernelFailed;
use App\Core\Kernel\Lifecycle\Events\KernelStarted;
use App\Core\Kernel\Lifecycle\Events\KernelStarting;
use App\Core\Kernel\Lifecycle\Listeners\KernelLifecycleListener;

final readonly class LifecycleEventRegistrar
{
    public function __construct(
        private EventRegistry $registry,
    ) {}


    public function register(): void
    {
        $this->registry->register(
            KernelStarting::class,
            KernelLifecycleListener::class,
        );


        $this->registry->register(
            KernelStarted::class,
            KernelLifecycleListener::class,
        );


        $this->registry->register(
            KernelFailed::class,
            KernelLifecycleListener::class,
        );
    }
}
