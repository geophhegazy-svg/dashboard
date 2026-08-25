<?php

declare(strict_types=1);

namespace Tests\Feature\Core\EventBus;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Core\EventBus\Contracts\ListenerResolverInterface;
use App\Core\EventBus\EventDispatcher;
use App\Core\EventBus\EventRegistry;
use App\Infrastructure\Laravel\EventBus\EventBridge;
use App\Infrastructure\Laravel\EventBus\LaravelListenerResolver;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class KernelEventBusServiceProviderTest extends TestCase
{
    public function test_event_contract_is_bridged_to_internal_event_bus(): void
    {
        $this->app->singleton(
            TestEventListener::class,
        );

        $registry = $this->app->make(
            EventRegistry::class,
        );

        $registry->register(
            TestEvent::class,
            TestEventListener::class,
        );

        Event::dispatch(
            new TestEvent(),
        );

        $listener = $this->app->make(
            TestEventListener::class,
        );

        self::assertTrue(
            $listener->handled,
        );
    }

    public function test_event_registry_is_registered_as_singleton(): void
    {
        $first = $this->app->make(
            EventRegistry::class,
        );

        $second = $this->app->make(
            EventRegistry::class,
        );

        self::assertSame(
            $first,
            $second,
        );
    }

    public function test_listener_resolver_is_registered_as_singleton(): void
    {
        $first = $this->app->make(
            ListenerResolverInterface::class,
        );

        $second = $this->app->make(
            ListenerResolverInterface::class,
        );

        self::assertInstanceOf(
            LaravelListenerResolver::class,
            $first,
        );

        self::assertSame(
            $first,
            $second,
        );
    }

    public function test_event_dispatcher_is_registered_as_singleton(): void
    {
        $first = $this->app->make(
            EventDispatcherInterface::class,
        );

        $second = $this->app->make(
            EventDispatcherInterface::class,
        );

        self::assertInstanceOf(
            EventDispatcher::class,
            $first,
        );

        self::assertSame(
            $first,
            $second,
        );
    }
}

final class TestEvent implements EventContract
{
}

final class TestEventListener implements EventListenerInterface
{
    public bool $handled = false;

    public function handle(EventContract $event): void
    {
        $this->handled = true;
    }
}
