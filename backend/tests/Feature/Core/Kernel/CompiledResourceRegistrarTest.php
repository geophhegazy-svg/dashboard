<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Registration\CompiledResourceRegistrar;
use LogicException;
use Mockery;
use Tests\TestCase;

final class CompiledResourceRegistrarTest extends TestCase
{
    public function test_it_rejects_a_resource_without_a_type(): void
    {
        $handler = Mockery::mock(CompiledResourceHandlerInterface::class);

        $handler
            ->shouldNotReceive('supports');

        $registrar = new CompiledResourceRegistrar([$handler]);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            'Compiled resource type is missing.'
        );

        $registrar->register(
            [],
            Mockery::mock(ModuleRegistrarInterface::class),
        );
    }

    public function test_it_rejects_an_unsupported_resource_type(): void
    {
        $handler = Mockery::mock(CompiledResourceHandlerInterface::class);

        $handler
            ->shouldReceive('supports')
            ->once()
            ->with('unsupported')
            ->andReturnFalse();

        $registrar = new CompiledResourceRegistrar([$handler]);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            'No compiled resource handler found for [unsupported].'
        );

        $registrar->register(
            ['type' => 'unsupported'],
            Mockery::mock(ModuleRegistrarInterface::class),
        );
    }

    public function test_it_stops_after_the_first_matching_handler(): void
    {
        $first = Mockery::mock(CompiledResourceHandlerInterface::class);
        $second = Mockery::mock(CompiledResourceHandlerInterface::class);

        $registrarMock = Mockery::mock(ModuleRegistrarInterface::class);

        $resource = [
            'type' => 'supported',
            'value' => 'example',
        ];

        $first
            ->shouldReceive('supports')
            ->once()
            ->with('supported')
            ->andReturnTrue();

        $first
            ->shouldReceive('register')
            ->once()
            ->with($resource, $registrarMock);

        $second
            ->shouldNotReceive('supports');

        $second
            ->shouldNotReceive('register');

        $registrar = new CompiledResourceRegistrar([
            $first,
            $second,
        ]);

        $registrar->register(
            $resource,
            $registrarMock,
        );

        self::addToAssertionCount(1);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
