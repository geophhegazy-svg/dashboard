<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;
use App\Core\Kernel\Registration\Handlers\ActionResourceHandler;
use App\Core\Kernel\Registration\Handlers\CommandHandlerResourceHandler;
use App\Core\Kernel\Registration\Handlers\CommandResourceHandler;
use App\Core\Kernel\Registration\Handlers\ListenerResourceHandler;
use App\Core\Kernel\Registration\Handlers\MigrationResourceHandler;
use App\Core\Kernel\Registration\Handlers\PolicyResourceHandler;
use App\Core\Kernel\Registration\Handlers\QueryResourceHandler;
use App\Core\Kernel\Registration\Handlers\ServiceResourceHandler;
use App\Core\Kernel\Registration\Handlers\SingletonResourceHandler;
use App\Core\Kernel\Resources\ActionResource;
use App\Core\Kernel\Resources\CommandHandlerResource;
use App\Core\Kernel\Resources\CommandResource;
use App\Core\Kernel\Resources\ListenerResource;
use App\Core\Kernel\Resources\MigrationResource;
use App\Core\Kernel\Resources\PolicyResource;
use App\Core\Kernel\Resources\QueryResource;
use App\Core\Kernel\Resources\ServiceResource;
use App\Core\Kernel\Resources\SingletonResource;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CompilableResourceHandlerCoverageTest extends TestCase
{
    /**
     * @return list<array{CompilableModuleResourceInterface, CompiledResourceHandlerInterface}>
     */
    public static function resourceHandlerProvider(): array
    {
        return [
            [
                new ServiceResource([]),
                new ServiceResourceHandler(),
            ],
            [
                new SingletonResource([]),
                new SingletonResourceHandler(),
            ],
            [
                new ActionResource([]),
                new ActionResourceHandler(),
            ],
            [
                new CommandResource([]),
                new CommandResourceHandler(),
            ],
            [
                new CommandHandlerResource([]),
                new CommandHandlerResourceHandler(),
            ],
            [
                new QueryResource([]),
                new QueryResourceHandler(),
            ],
            [
                new ListenerResource([]),
                new ListenerResourceHandler(),
            ],
            [
                new PolicyResource([]),
                new PolicyResourceHandler(),
            ],
            [
                new MigrationResource([]),
                new MigrationResourceHandler(),
            ],
        ];
    }

    #[DataProvider('resourceHandlerProvider')]
    public function test_every_compilable_resource_has_a_matching_handler(
        CompilableModuleResourceInterface $resource,
        CompiledResourceHandlerInterface $handler,
    ): void {
        $compiled = $resource->compile();

        $this->assertArrayHasKey('type', $compiled);

        $this->assertTrue(
            $handler->supports($compiled['type']),
            sprintf(
                'Handler [%s] does not support compiled resource type [%s].',
                $handler::class,
                $compiled['type'],
            ),
        );
    }
}
