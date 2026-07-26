<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Events\KernelBooted;
use App\Core\Kernel\Events\KernelBooting;
use App\Core\Kernel\Events\ModuleBooted;
use App\Core\Kernel\Events\ModuleBooting;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use Tests\Fakes\Core\FakeEventDispatcher;
use Tests\TestCase;
use App\Core\Kernel\Registration\ModuleRegistrationService;
use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
final class KernelLifecycleTest extends TestCase
{
    public function test_kernel_dispatches_lifecycle_events(): void
    {
        $events = new FakeEventDispatcher();

        $this->app->instance(
            EventDispatcherInterface::class,
            $events,
        );

        $this->app->forgetInstance(
            KernelBootstrapperInterface::class
        );

        $this->app->forgetInstance(
            ModuleRegistrationService::class
        );

        $this->app
            ->make(KernelLifecycleManager::class)
            ->reset();


        $this->app
            ->make(KernelRuntimeState::class)
            ->reset();


        $this->app
            ->make(
                \App\Core\Kernel\Contracts\KernelBootstrapperInterface::class
            )
            ->boot();


        $this->assertTrue(
            $events->has(KernelBooting::class),
        );


        $this->assertTrue(
            $events->has(KernelBooted::class),
        );


        $this->assertTrue(
            $events->has(ModuleBooting::class),
        );


        $this->assertTrue(
            $events->has(ModuleBooted::class),
        );
    }
}
