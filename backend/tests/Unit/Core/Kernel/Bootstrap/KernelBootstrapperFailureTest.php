<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Bootstrap;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Kernel\Bootstrap\KernelBootstrapper;
use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\Contracts\KernelValidatorInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Lifecycle\Events\KernelFailed;
use App\Core\Kernel\Lifecycle\Events\KernelStarted;
use App\Core\Kernel\Lifecycle\Events\KernelStarting;
use App\Core\Kernel\Events\KernelBooted;
use App\Core\Kernel\Events\KernelBooting;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use App\Core\Kernel\Monitoring\KernelBootTimeline;
use App\Core\Kernel\Registration\CompiledManifestRegistrationService;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use App\Core\Kernel\Validation\ValidationError;
use App\Core\Kernel\Validation\ValidationErrorCode;
use App\Core\Kernel\Validation\ValidationResult;
use Tests\TestCase;
use RuntimeException;
use Tests\Fakes\Core\FakeEventDispatcher;

final class KernelBootstrapperFailureTest extends TestCase
{
    public function test_discovery_failure_moves_kernel_to_failed_and_dispatches_failure(): void
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

        $validator = $this->createStub(
            KernelValidatorInterface::class,
        );

        $manifestProvider = $this->app->make(
            CompiledManifestProvider::class,
        );

        $registration = $this->app->make(
            CompiledManifestRegistrationService::class,
        );

        $registrar = $this->createStub(
            ModuleRegistrarInterface::class,
        );

        $runtime = new KernelRuntimeState();

        $lifecycle = new KernelLifecycleManager();

        $timeline = new KernelBootTimeline();

        $events = new FakeEventDispatcher();

        $lifecycleEvents = $this->app->make(
            \App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar::class,
        );

        $bootstrapper = new KernelBootstrapper(
            $loader,
            $validator,
            $manifestProvider,
            $registration,
            $registrar,
            $runtime,
            $lifecycle,
            $timeline,
            $events,
            $lifecycleEvents,
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
            KernelLifecycleState::Failed,
            $lifecycle->state(),
        );

        $types = array_map(
            static fn ($event): string => $event::class,
            $events->all(),
        );

        self::assertSame(
            [
                KernelStarting::class,
                KernelBooting::class,
                KernelFailed::class,
            ],
            $types,
        );
    }

    public function test_failure_after_runtime_initialization_resets_runtime_state(): void
    {
        $exception = new RuntimeException(
            'runtime initialization boundary failed',
        );

        $loader = $this->createMock(
            ModuleLoaderInterface::class,
        );

        $loader
            ->expects(self::once())
            ->method('reset');

        $registry = new \App\Core\Kernel\ModuleRegistry();

        $loader
            ->expects(self::once())
            ->method('load')
            ->willReturn($registry);

        $validator = $this->createMock(
            KernelValidatorInterface::class,
        );

        $validator
            ->expects(self::once())
            ->method('validate')
            ->with($registry)
            ->willReturn(
                new ValidationResult(),
            );

        $manifestProvider = $this->app->make(
            CompiledManifestProvider::class,
        );

        $registration = $this->app->make(
            CompiledManifestRegistrationService::class,
        );

        $registrar = $this->createStub(
            ModuleRegistrarInterface::class,
        );

        $runtime = new KernelRuntimeState();

        $lifecycle = new KernelLifecycleManager();

        $timeline = new KernelBootTimeline();

        $events = new class($exception) implements EventDispatcherInterface {
            /**
             * @var list<EventContract>
             */
            private array $events = [];

            public function __construct(
                private readonly RuntimeException $exception,
            ) {}

            public function dispatch(
                EventContract $event,
            ): void {
                $this->events[] = $event;

                if ($event instanceof KernelStarted) {
                    throw $this->exception;
                }
            }

            /**
             * @return list<EventContract>
             */
            public function all(): array
            {
                return $this->events;
            }
        };

        $lifecycleEvents = $this->app->make(
            \App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar::class,
        );

        $bootstrapper = new KernelBootstrapper(
            $loader,
            $validator,
            $manifestProvider,
            $registration,
            $registrar,
            $runtime,
            $lifecycle,
            $timeline,
            $events,
            $lifecycleEvents,
        );

        try {
            $bootstrapper->boot();

            self::fail(
                'Expected runtime boundary exception was not rethrown.',
            );
        } catch (RuntimeException $caught) {
            self::assertSame(
                $exception,
                $caught,
            );
        }

        self::assertSame(
            KernelLifecycleState::Failed,
            $lifecycle->state(),
        );

        self::assertFalse(
            $runtime->isBooted(),
            'Failed kernel boot must not leave runtime state initialized.',
        );

        $types = array_map(
            static fn (EventContract $event): string => $event::class,
            $events->all(),
        );

        self::assertContains(
            KernelFailed::class,
            $types,
        );

        self::assertNotContains(
            KernelBooted::class,
            $types,
        );
    }

    public function test_validation_failure_does_not_start_kernel(): void
    {
        $exception = new RuntimeException('validation failed');

        $loader = $this->createMock(
            ModuleLoaderInterface::class,
        );

        $loader
            ->expects(self::once())
            ->method('reset');

        $registry = new \App\Core\Kernel\ModuleRegistry();

        /*
         * Validation failure is injected through the validator.
         * The loader itself must still complete normally.
         */
        $loader
            ->expects(self::once())
            ->method('load')
            ->willReturn($registry);

        $validator = $this->createMock(
            KernelValidatorInterface::class,
        );

        $result = new ValidationResult(
            errors: [
                new ValidationError(
                    ValidationErrorCode::cases()[0],
                    $exception->getMessage(),
                ),
            ],
        );

        $validator
            ->expects(self::once())
            ->method('validate')
            ->with($registry)
            ->willReturn($result);

        $manifestProvider = $this->app->make(
            CompiledManifestProvider::class,
        );

        $registration = $this->app->make(
            CompiledManifestRegistrationService::class,
        );

        $registrar = $this->createStub(
            ModuleRegistrarInterface::class,
        );

        $runtime = new KernelRuntimeState();

        $lifecycle = new KernelLifecycleManager();

        $timeline = new KernelBootTimeline();

        $events = new FakeEventDispatcher();

        $lifecycleEvents = $this->app->make(
            \App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar::class,
        );

        $bootstrapper = new KernelBootstrapper(
            $loader,
            $validator,
            $manifestProvider,
            $registration,
            $registrar,
            $runtime,
            $lifecycle,
            $timeline,
            $events,
            $lifecycleEvents,
        );

        try {
            $bootstrapper->boot();

            self::fail(
                'Expected validation exception was not rethrown.',
            );
        } catch (RuntimeException $caught) {
            self::assertStringContainsString(
                'Kernel validation failed.',
                $caught->getMessage(),
            );
        }

        self::assertSame(
            KernelLifecycleState::Failed,
            $lifecycle->state(),
        );

        $types = array_map(
            static fn ($event): string => $event::class,
            $events->all(),
        );

        self::assertContains(
            KernelStarting::class,
            $types,
        );

        self::assertContains(
            KernelBooting::class,
            $types,
        );

        self::assertContains(
            KernelFailed::class,
            $types,
        );

        self::assertNotContains(
            KernelStarted::class,
            $types,
        );

        self::assertNotContains(
            KernelBooted::class,
            $types,
        );
    }
}
