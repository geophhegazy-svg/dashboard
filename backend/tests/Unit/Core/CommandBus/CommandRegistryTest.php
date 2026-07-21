<?php

declare(strict_types=1);

namespace Tests\Unit\Core\CommandBus;

use Tests\TestCase;
use App\Core\CommandBus\CommandRegistry;

final class CommandRegistryTest extends TestCase
{
    public function test_it_registers_commands(): void
    {
        $registry = new CommandRegistry();

        $registry->register(
            DummyCommand::class,
            DummyHandler::class,
        );

        $descriptor = $registry->get(
            DummyCommand::class
        );

        $this->assertNotNull($descriptor);

        $this->assertSame(
            DummyHandler::class,
            $descriptor->handler,
        );
    }
}


final class DummyCommand {}


final class DummyHandler {}
