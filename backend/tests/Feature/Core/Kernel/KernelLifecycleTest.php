<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Events\KernelBooted;
use App\Core\Kernel\Events\KernelBooting;
use App\Core\Kernel\Events\ModuleBooted;
use App\Core\Kernel\Events\ModuleBooting;
use App\Core\Kernel\Lifecycle\Events\KernelStarting;
use App\Core\Kernel\Lifecycle\Events\KernelStarted;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use Tests\Fakes\Core\FakeEventDispatcher;
use Tests\TestCase;
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
            \App\Core\Kernel\Registration\CompiledManifestRegistrationService::class
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

        $dispatched = $events->all();

        $types = array_map(
            static fn(object $event): string => $event::class,
            $dispatched,
        );

        $positions = [
            KernelStarting::class => array_search(
                KernelStarting::class,
                $types,
                true,
            ),
            KernelBooting::class => array_search(
                KernelBooting::class,
                $types,
                true,
            ),
            ModuleBooting::class => array_search(
                ModuleBooting::class,
                $types,
                true,
            ),
            ModuleBooted::class => array_search(
                ModuleBooted::class,
                $types,
                true,
            ),
            KernelStarted::class => array_search(
                KernelStarted::class,
                $types,
                true,
            ),
            KernelBooted::class => array_search(
                KernelBooted::class,
                $types,
                true,
            ),
        ];

        foreach ($positions as $event => $position) {
            self::assertNotFalse(
                $position,
                "Expected event {$event} was not dispatched.",
            );
        }

        self::assertLessThan(
            $positions[KernelBooting::class],
            $positions[KernelStarting::class],
        );

        self::assertLessThan(
            $positions[ModuleBooting::class],
            $positions[KernelBooting::class],
        );

        self::assertLessThan(
            $positions[ModuleBooted::class],
            $positions[ModuleBooting::class],
        );

        self::assertLessThan(
            $positions[KernelStarted::class],
            $positions[ModuleBooted::class],
        );

        self::assertLessThan(
            $positions[KernelBooted::class],
            $positions[KernelStarted::class],
        );
    }
}
