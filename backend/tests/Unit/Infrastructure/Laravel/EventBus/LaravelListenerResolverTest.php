<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\EventBus;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Infrastructure\Laravel\EventBus\LaravelListenerResolver;
use LogicException;
use Tests\TestCase;

final class LaravelListenerResolverTest extends TestCase
{
    public function test_it_resolves_listener_through_laravel_container(): void
    {
        $resolver = new LaravelListenerResolver();

        $listener = $resolver->resolve(
            TestLaravelListener::class,
        );

        self::assertInstanceOf(
            TestLaravelListener::class,
            $listener,
        );

        self::assertInstanceOf(
            EventListenerInterface::class,
            $listener,
        );

        self::assertInstanceOf(
            TestLaravelListener::class,
            $this->app->make(TestLaravelListener::class),
        );
    }

    public function test_it_rejects_resolved_instance_that_does_not_implement_listener_contract(): void
    {
        $resolver = new LaravelListenerResolver();

        $this->expectException(LogicException::class);

        $this->expectExceptionMessage(
            'TestInvalidListener must implement ' .
            EventListenerInterface::class . '.',
        );

        $resolver->resolve(
            TestInvalidListener::class,
        );
    }
}

final class TestLaravelListener implements EventListenerInterface
{
    public function handle(
        EventContract $event,
    ): void {
    }
}

final class TestInvalidListener
{
}
