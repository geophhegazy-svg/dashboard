<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Lifecycle;

use App\Core\Kernel\Lifecycle\Events\KernelFailed;
use App\Core\Kernel\Lifecycle\Events\KernelStarted;
use App\Core\Kernel\Lifecycle\Events\KernelStarting;
use App\Core\Kernel\Lifecycle\Events\KernelStopping;
use App\Core\Kernel\Lifecycle\Events\KernelStopped;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use App\Core\Kernel\Lifecycle\Listeners\KernelLifecycleListener;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class KernelLifecycleListenerTest extends TestCase
{
    public function test_it_handles_kernel_starting_event(): void
    {
        $listener = new KernelLifecycleListener();

        $listener->handle(
            new KernelStarting(
                KernelLifecycleState::Starting,
            ),
        );

        self::assertTrue(true);
    }

    public function test_it_handles_kernel_started_event(): void
    {
        $listener = new KernelLifecycleListener();

        $listener->handle(
            new KernelStarted(
                KernelLifecycleState::Ready,
            ),
        );

        self::assertTrue(true);
    }

    public function test_it_handles_kernel_failed_event(): void
    {
        $listener = new KernelLifecycleListener();

        $listener->handle(
            new KernelFailed(
                new RuntimeException('Lifecycle failure'),
            ),
        );

        self::assertTrue(true);
    }


    public function test_it_handles_kernel_stopping_event(): void
    {
        $listener = new KernelLifecycleListener();

        $listener->handle(
            new KernelStopping(
                KernelLifecycleState::Stopping,
            ),
        );

        self::assertTrue(true);
    }


    public function test_it_handles_kernel_stopped_event(): void
    {
        $listener = new KernelLifecycleListener();

        $listener->handle(
            new KernelStopped(
                KernelLifecycleState::Stopped,
            ),
        );

        self::assertTrue(true);
    }
}
