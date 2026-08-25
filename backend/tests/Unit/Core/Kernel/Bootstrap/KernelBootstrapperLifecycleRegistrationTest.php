<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Bootstrap;

use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\EventBus\EventRegistry;
use App\Core\Kernel\Bootstrap\KernelBootstrapper;
use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\Contracts\KernelValidatorInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Lifecycle\Events\KernelFailed;
use App\Core\Kernel\Lifecycle\Events\KernelStarting;
use App\Core\Kernel\Lifecycle\Events\KernelStarted;
use App\Core\Kernel\Events\KernelBooted;
use App\Core\Kernel\Events\KernelBooting;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use App\Core\Kernel\Lifecycle\Listeners\KernelLifecycleListener;
use App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar;
use App\Core\Kernel\Monitoring\KernelBootTimeline;
use App\Core\Kernel\Monitoring\KernelBootStage;
use App\Core\Kernel\Registration\CompiledManifestRegistrationService;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use App\Core\Kernel\ModuleRegistry;
use RuntimeException;
use Tests\TestCase;
use Tests\Fakes\Core\FakeEventDispatcher;

final class KernelBootstrapperLifecycleRegistrationTest extends TestCase
{
    public function test_successful_boot_dispatches_lifecycle_events_in_order(): void
    {
        $loader = $this->createMock(ModuleLoaderInterface::class);

        $loader
            ->expects(self::once())
            ->method('reset');

        $loader
            ->expects(self::once())
            ->method('load')
            ->willReturn(new ModuleRegistry());

        $runtime = new KernelRuntimeState();
        $lifecycle = new KernelLifecycleManager();
        $events = new FakeEventDispatcher();
        $timeline = new KernelBootTimeline();

        $bootstrapper = new KernelBootstrapper(
            $loader,
            $this->validatingKernelValidator(),
            $this->app->make(CompiledManifestProvider::class),
            $this->app->make(CompiledManifestRegistrationService::class),
            $this->createStub(ModuleRegistrarInterface::class),
            $runtime,
            $lifecycle,
            $timeline,
            $events,
            $this->app->make(LifecycleEventRegistrar::class),
        );

        $bootstrapper->boot();

        self::assertSame(KernelLifecycleState::Ready, $lifecycle->state());
        self::assertTrue($runtime->isBooted());
        self::assertSame(
            KernelBootStage::cases(),
            array_map(
                static fn ($metric): KernelBootStage => $metric->stage(),
                $timeline->metrics(),
            ),
        );
        self::assertSame(
            [
                KernelStarting::class,
                KernelBooting::class,
                KernelStarted::class,
                KernelBooted::class,
            ],
            array_map(
                static fn (object $event): string => $event::class,
                $events->all(),
            ),
        );
    }

    public function test_lifecycle_listeners_are_registered_before_boot_events(): void
    {
        $registry = $this->app->make(EventRegistry::class);

        $loader = $this->createMock(
            ModuleLoaderInterface::class,
        );

        $loader
            ->expects(self::once())
            ->method('reset');

        $loader
            ->expects(self::once())
            ->method('load')
            ->willReturn(new ModuleRegistry());

        $bootstrapper = $this->makeBootstrapper(
            loader: $loader,
        );

        /*
         * The bootstrapper must register lifecycle listeners before
         * dispatching the first lifecycle event.
         */
        $bootstrapper->boot();

        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(new KernelStarting(
                KernelLifecycleState::Starting,
            )),
        );

        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(new KernelStarted(
                KernelLifecycleState::Ready,
            )),
        );

        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(new KernelFailed(
                new RuntimeException('test'),
            )),
        );
    }

    public function test_lifecycle_failed_listener_is_registered_when_discovery_fails(): void
    {
        $exception = new RuntimeException('discovery failed');

        $loader = $this->createMock(
            ModuleLoaderInterface::class,
        );

        $loader
            ->expects(self::once())
            ->method('reset');

        $loader
            ->expects(self::once())
            ->method('load')
            ->willThrowException($exception);

        $registry = $this->app->make(EventRegistry::class);

        $bootstrapper = $this->makeBootstrapper(
            loader: $loader,
        );

        try {
            $bootstrapper->boot();

            self::fail(
                'Expected discovery exception was not rethrown.',
            );
        } catch (RuntimeException $caught) {
            self::assertSame(
                $exception,
                $caught,
            );
        }

        self::assertSame(
            [KernelLifecycleListener::class],
            $registry->listenersFor(
                new KernelFailed($exception),
            ),
            'KernelFailed must have its lifecycle listener registered before discovery starts.',
        );
    }

    private function makeBootstrapper(
        ModuleLoaderInterface $loader,
    ): KernelBootstrapper {
        return new KernelBootstrapper(
            $loader,
            $this->validatingKernelValidator(),
            $this->app->make(CompiledManifestProvider::class),
            $this->app->make(CompiledManifestRegistrationService::class),
            $this->createStub(ModuleRegistrarInterface::class),
            new KernelRuntimeState(),
            new KernelLifecycleManager(),
            new KernelBootTimeline(),
            $this->app->make(EventDispatcherInterface::class),
            $this->app->make(LifecycleEventRegistrar::class),
        );
    }

    private function validatingKernelValidator(): KernelValidatorInterface
    {
        $validator = $this->createStub(KernelValidatorInterface::class);

        $validator
            ->method('validate')
            ->willReturn(new \App\Core\Kernel\Validation\ValidationResult());

        return $validator;
    }
}
