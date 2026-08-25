<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Contracts\KernelShutdownManagerInterface;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use Tests\TestCase;

final class KernelLaravelTerminationTest extends TestCase
{
    public function test_laravel_termination_invokes_the_kernel_shutdown_owner(): void
    {
        $lifecycle = $this->app->make(
            KernelLifecycleManager::class,
        );

        $this->assertSame(
            KernelLifecycleState::Ready,
            $lifecycle->state(),
        );

        $this->assertInstanceOf(
            KernelShutdownManagerInterface::class,
            $this->app->make(
                KernelShutdownManagerInterface::class,
            ),
        );

        $this->app->terminate();

        $this->assertSame(
            KernelLifecycleState::Stopped,
            $lifecycle->state(),
        );
    }
}
