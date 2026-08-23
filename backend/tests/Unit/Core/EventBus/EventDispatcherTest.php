<?php

declare(strict_types=1);

namespace Tests\Unit\Core\EventBus;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Core\EventBus\Contracts\ListenerResolverInterface;
use App\Core\EventBus\EventDispatcher;
use App\Core\EventBus\EventRegistry;
use LogicException;
use PHPUnit\Framework\TestCase;

final class EventDispatcherTest extends TestCase
{
    public function test_it_resolves_and_invokes_registered_listener(): void
    {
        $event = new TestEvent();

        $listener = new TestListener();

        $registry = new EventRegistry();

        $registry->register(
            TestEvent::class,
            TestListener::class,
        );

        $resolver = new TestListenerResolver([
            TestListener::class => $listener,
        ]);

        $dispatcher = new EventDispatcher(
            $registry,
            $resolver,
        );

        $dispatcher->dispatch($event);

        self::assertSame(
            [$event],
            $listener->events,
        );

        self::assertSame(
            [TestListener::class],
            $resolver->resolved,
        );
    }

    public function test_it_invokes_all_registered_listeners(): void
    {
        $event = new TestEvent();

        $first = new TestFirstListener();
        $second = new TestSecondListener();

        $registry = new EventRegistry();

        $registry->register(
            TestEvent::class,
            TestFirstListener::class,
        );

        $registry->register(
            TestEvent::class,
            TestSecondListener::class,
        );

        $resolver = new TestListenerResolver([
            TestFirstListener::class => $first,
            TestSecondListener::class => $second,
        ]);

        $dispatcher = new EventDispatcher(
            $registry,
            $resolver,
        );

        $dispatcher->dispatch($event);

        self::assertSame(
            [$event],
            $first->events,
        );

        self::assertSame(
            [$event],
            $second->events,
        );

        self::assertSame(
            [
                TestFirstListener::class,
                TestSecondListener::class,
            ],
            $resolver->resolved,
        );
    }

    public function test_it_does_not_resolve_when_no_listener_is_registered(): void
    {
        $event = new TestEvent();

        $registry = new EventRegistry();

        $resolver = new TestListenerResolver();

        $dispatcher = new EventDispatcher(
            $registry,
            $resolver,
        );

        $dispatcher->dispatch($event);

        self::assertSame(
            [],
            $resolver->resolved,
        );
    }
}

final readonly class TestEvent implements EventContract
{
}

class TestListener implements EventListenerInterface
{
    /**
     * @var list<EventContract>
     */
    public array $events = [];

    public function handle(
        EventContract $event,
    ): void {
        $this->events[] = $event;
    }
}

final class TestFirstListener extends TestListener
{
}

final class TestSecondListener extends TestListener
{
}

final class TestListenerResolver implements ListenerResolverInterface
{
    /**
     * @var array<string, EventListenerInterface>
     */
    private array $listeners;

    /**
     * @var list<string>
     */
    public array $resolved = [];

    /**
     * @param array<string, EventListenerInterface> $listeners
     */
    public function __construct(
        array $listeners = [],
    ) {
        $this->listeners = $listeners;
    }

    public function resolve(
        string $listener,
    ): EventListenerInterface {
        $this->resolved[] = $listener;

        if (! isset($this->listeners[$listener])) {
            throw new LogicException(
                "Listener was not registered in test resolver: {$listener}",
            );
        }

        return $this->listeners[$listener];
    }
}
