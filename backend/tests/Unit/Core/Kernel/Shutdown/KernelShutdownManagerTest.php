<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Shutdown;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Lifecycle\Events\KernelStopped;
use App\Core\Kernel\Lifecycle\Events\KernelStopping;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use App\Core\Kernel\Runtime\KernelRuntimeContext;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use App\Core\Kernel\Shutdown\KernelShutdownManager;
use DateTimeImmutable;
use Tests\TestCase;

final class KernelShutdownManagerTest extends TestCase
{
    public function test_it_shuts_down_a_ready_kernel(): void
    {
        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            KernelLifecycleState::Starting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Booting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Ready,
        );

        $runtime = new KernelRuntimeState();

        $runtime->set(
            new KernelRuntimeContext(
                new CompiledModuleManifest([]),
                new DateTimeImmutable(),
            ),
        );

        $events = new RecordingEventDispatcher();

        $manager = new KernelShutdownManager(
            lifecycle: $lifecycle,
            runtime: $runtime,
            events: $events,
        );

        $manager->shutdown();

        self::assertSame(
            KernelLifecycleState::Stopped,
            $lifecycle->state(),
        );

        self::assertFalse(
            $runtime->isBooted(),
        );

        self::assertSame(
            [
                KernelStopping::class,
                KernelStopped::class,
            ],
            $events->types(),
        );
    }

    public function test_it_shuts_down_a_failed_kernel(): void
    {
        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            KernelLifecycleState::Starting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Failed,
        );

        $runtime = new KernelRuntimeState();

        $runtime->set(
            new KernelRuntimeContext(
                new CompiledModuleManifest([]),
                new DateTimeImmutable(),
            ),
        );

        $events = new RecordingEventDispatcher();

        $manager = new KernelShutdownManager(
            lifecycle: $lifecycle,
            runtime: $runtime,
            events: $events,
        );

        $manager->shutdown();

        self::assertSame(
            KernelLifecycleState::Stopped,
            $lifecycle->state(),
        );

        self::assertFalse(
            $runtime->isBooted(),
        );

        self::assertSame(
            [
                KernelStopped::class,
            ],
            $events->types(),
        );
    }

    public function test_it_is_idempotent_after_stopped_state(): void
    {
        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            KernelLifecycleState::Starting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Booting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Ready,
        );

        $lifecycle->transition(
            KernelLifecycleState::Stopping,
        );

        $lifecycle->transition(
            KernelLifecycleState::Stopped,
        );

        $events = new RecordingEventDispatcher();

        $manager = new KernelShutdownManager(
            lifecycle: $lifecycle,
            runtime: new KernelRuntimeState(),
            events: $events,
        );

        $manager->shutdown();

        self::assertSame(
            KernelLifecycleState::Stopped,
            $lifecycle->state(),
        );

        self::assertSame(
            [],
            $events->types(),
        );
    }

    public function test_it_does_not_shutdown_a_kernel_that_is_not_ready_or_failed(): void
    {
        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            KernelLifecycleState::Starting,
        );

        $events = new RecordingEventDispatcher();

        $manager = new KernelShutdownManager(
            lifecycle: $lifecycle,
            runtime: new KernelRuntimeState(),
            events: $events,
        );

        $manager->shutdown();

        self::assertSame(
            KernelLifecycleState::Starting,
            $lifecycle->state(),
        );

        self::assertSame(
            [],
            $events->types(),
        );
    }
}

final class RecordingEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var list<EventContract>
     */
    private array $events = [];

    public function dispatch(
        EventContract $event,
    ): void {
        $this->events[] = $event;
    }

    /**
     * @return list<class-string<EventContract>>
     */
    public function types(): array
    {
        return array_map(
            static fn (EventContract $event): string => $event::class,
            $this->events,
        );
    }
}
