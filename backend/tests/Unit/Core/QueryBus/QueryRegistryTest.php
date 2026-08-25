<?php

declare(strict_types=1);

namespace Tests\Unit\Core\QueryBus;

use App\Core\QueryBus\QueryRegistry;
use PHPUnit\Framework\TestCase;

final class QueryRegistryTest extends TestCase
{
    public function test_it_registers_and_retrieves_a_query_handler(): void
    {
        $registry = new QueryRegistry();

        $registry->register(
            RegistryTestQuery::class,
            RegistryTestHandler::class,
        );

        $descriptor = $registry->get(
            RegistryTestQuery::class,
        );

        self::assertNotNull($descriptor);
        self::assertSame(
            RegistryTestQuery::class,
            $descriptor->query,
        );
        self::assertSame(
            RegistryTestHandler::class,
            $descriptor->handler,
        );
        self::assertTrue(
            $registry->has(RegistryTestQuery::class),
        );
    }

    public function test_it_returns_null_for_an_unregistered_query(): void
    {
        $registry = new QueryRegistry();

        self::assertFalse(
            $registry->has(RegistryTestQuery::class),
        );

        self::assertNull(
            $registry->get(RegistryTestQuery::class),
        );
    }

    public function test_it_returns_registered_query_classes(): void
    {
        $registry = new QueryRegistry();

        $registry->register(
            RegistryTestQuery::class,
            RegistryTestHandler::class,
        );

        self::assertSame(
            [RegistryTestQuery::class],
            $registry->all(),
        );
    }
}

final class RegistryTestQuery
{
}

final class RegistryTestHandler
{
}
