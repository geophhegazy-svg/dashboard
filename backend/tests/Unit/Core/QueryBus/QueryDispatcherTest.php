<?php

declare(strict_types=1);

namespace Tests\Unit\Core\QueryBus;

use App\Core\Contracts\ContainerInterface;
use App\Core\QueryBus\Contracts\QueryHandlerInterface;
use App\Core\QueryBus\Contracts\QueryInterface;
use App\Core\QueryBus\QueryDispatcher;
use App\Core\QueryBus\QueryRegistry;
use LogicException;
use PHPUnit\Framework\TestCase;

final class QueryDispatcherTest extends TestCase
{
    public function test_it_resolves_and_invokes_the_registered_handler(): void
    {
        $query = new DispatcherTestQuery('EgyptNet');

        $handler = new DispatcherTestHandler();

        $registry = new QueryRegistry();

        $registry->register(
            DispatcherTestQuery::class,
            DispatcherTestHandler::class,
        );

        $container = new DispatcherTestContainer([
            DispatcherTestHandler::class => $handler,
        ]);

        $dispatcher = new QueryDispatcher(
            $registry,
            $container,
        );

        $result = $dispatcher->dispatch($query);

        self::assertSame(
            'handled:EgyptNet',
            $result,
        );

        self::assertSame(
            [$query],
            $handler->handled,
        );

        self::assertSame(
            [DispatcherTestHandler::class],
            $container->resolved,
        );
    }

    public function test_it_rejects_an_unregistered_query(): void
    {
        $registry = new QueryRegistry();

        $container = new DispatcherTestContainer();

        $dispatcher = new QueryDispatcher(
            $registry,
            $container,
        );

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Query [%s] is not registered.',
                DispatcherTestQuery::class,
            ),
        );

        $dispatcher->dispatch(
            new DispatcherTestQuery('EgyptNet'),
        );

        self::fail(
            'The container must not be resolved for an unregistered query.',
        );
    }
}

final readonly class DispatcherTestQuery implements QueryInterface
{
    public function __construct(
        public string $value,
    ) {
    }
}

final class DispatcherTestHandler implements QueryHandlerInterface
{
    /**
     * @var list<QueryInterface>
     */
    public array $handled = [];

    public function handle(
        QueryInterface $query,
    ): mixed {
        $this->handled[] = $query;

        return 'handled:' . $query->value;
    }
}

final class DispatcherTestContainer implements ContainerInterface
{
    /**
     * @var array<class-string,object>
     */
    private array $bindings;

    /**
     * @var list<class-string>
     */
    public array $resolved = [];

    /**
     * @param array<class-string,object> $bindings
     */
    public function __construct(
        array $bindings = [],
    ) {
        $this->bindings = $bindings;
    }

    public function make(
        string $abstract,
    ): object {
        $this->resolved[] = $abstract;

        return $this->bindings[$abstract]
            ?? throw new LogicException(
                "Test container has no binding for [{$abstract}].",
            );
    }
}
