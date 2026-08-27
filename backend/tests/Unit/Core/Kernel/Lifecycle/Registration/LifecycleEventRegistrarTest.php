<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Lifecycle\Registration;

use App\Core\EventBus\EventRegistry;
use App\Core\Kernel\Lifecycle\Events\KernelFailed;
use App\Core\Kernel\Lifecycle\Events\KernelStarted;
use App\Core\Kernel\Lifecycle\Events\KernelStarting;
use App\Core\Kernel\Lifecycle\Events\KernelStopping;
use App\Core\Kernel\Lifecycle\Events\KernelStopped;
use App\Core\Kernel\Lifecycle\Listeners\KernelLifecycleListener;
use App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class LifecycleEventRegistrarTest extends TestCase
{
    public function test_it_registers_all_kernel_lifecycle_events(): void
    {
        $registry = new EventRegistry();

        $registrar = new LifecycleEventRegistrar(
            $registry,
        );

        $registrar->register();

        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(
                new KernelStarting(
                    \App\Core\Kernel\Lifecycle\KernelLifecycleState::Starting,
                ),
            ),
        );

        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(
                new KernelStarted(
                    \App\Core\Kernel\Lifecycle\KernelLifecycleState::Ready,
                ),
            ),
        );

        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(
                new KernelFailed(
                    new RuntimeException('test'),
                ),
            ),
        );


        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(
                new KernelStopping(
                    \App\Core\Kernel\Lifecycle\KernelLifecycleState::Stopping,
                ),
            ),
        );

        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(
                new KernelStopped(
                    \App\Core\Kernel\Lifecycle\KernelLifecycleState::Stopped,
                ),
            ),
        );
    }
}
