<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Registration\Handlers\CommandResourceHandler;
use App\Core\Kernel\Resources\ResourceType;
use Mockery;
use Tests\TestCase;

final class CommandResourceHandlerTest extends TestCase
{
    public function test_it_supports_command_resources(): void
    {
        $handler = new CommandResourceHandler();

        self::assertTrue(
            $handler->supports(ResourceType::Commands->value),
        );

        self::assertFalse(
            $handler->supports(ResourceType::Services->value),
        );
    }

    public function test_it_registers_compiled_commands(): void
    {
        $registrar = Mockery::mock(
            ModuleRegistrarInterface::class,
        );

        $registrar
            ->shouldReceive('registerCommand')
            ->once()
            ->with(CommandResourceHandlerCommandOne::class);

        $registrar
            ->shouldReceive('registerCommand')
            ->once()
            ->with(CommandResourceHandlerCommandTwo::class);

        $handler = new CommandResourceHandler();

        $handler->register(
            [
                'type' => ResourceType::Commands->value,
                'commands' => [
                    CommandResourceHandlerCommandOne::class,
                    CommandResourceHandlerCommandTwo::class,
                ],
            ],
            $registrar,
        );

        self::addToAssertionCount(1);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

final class CommandResourceHandlerCommandOne
{
}

final class CommandResourceHandlerCommandTwo
{
}
