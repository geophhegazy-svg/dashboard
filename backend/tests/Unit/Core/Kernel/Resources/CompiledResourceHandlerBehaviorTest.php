<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Registration\Handlers\ActionResourceHandler;
use App\Core\Kernel\Registration\Handlers\CommandHandlerResourceHandler;
use App\Core\Kernel\Registration\Handlers\CommandResourceHandler;
use App\Core\Kernel\Registration\Handlers\MigrationResourceHandler;
use App\Core\Kernel\Registration\Handlers\ListenerResourceHandler;
use App\Core\Kernel\Registration\Handlers\PolicyResourceHandler;
use App\Core\Kernel\Registration\Handlers\QueryResourceHandler;
use App\Core\Kernel\Registration\Handlers\ServiceResourceHandler;
use App\Core\Kernel\Registration\Handlers\SingletonResourceHandler;
use App\Core\Kernel\Resources\ResourceType;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CompiledResourceHandlerBehaviorTest extends TestCase
{
    /**
     * @return list<array{
     *     CompiledResourceHandlerInterface,
     *     string,
     *     array<string,mixed>,
     *     string,
     *     list<array{string,...}>
     * }>
     */
    public static function handlerProvider(): array
    {
        return [
            [
                new ActionResourceHandler(),
                ResourceType::Actions->value,
                [
                    'type' => ResourceType::Actions->value,
                    'actions' => [
                        ActionHandlerBehaviorActionOne::class,
                        ActionHandlerBehaviorActionTwo::class,
                    ],
                ],
                'registerAction',
                [
                    ['registerAction', ActionHandlerBehaviorActionOne::class],
                    ['registerAction', ActionHandlerBehaviorActionTwo::class],
                ],
            ],
            [
                new CommandResourceHandler(),
                ResourceType::Commands->value,
                [
                    'type' => ResourceType::Commands->value,
                    'commands' => [
                        CommandHandlerBehaviorCommand::class,
                        CommandHandlerBehaviorSecondCommand::class,
                    ],
                ],
                'registerCommand',
                [
                    [
                        'registerCommand',
                        CommandHandlerBehaviorCommand::class,
                    ],
                    [
                        'registerCommand',
                        CommandHandlerBehaviorSecondCommand::class,
                    ],
                ],
            ],
            [
                new CommandHandlerResourceHandler(),
                ResourceType::CommandHandlers->value,
                [
                    'type' => ResourceType::CommandHandlers->value,
                    'handlers' => [
                        CommandHandlerBehaviorCommand::class
                            => CommandHandlerBehaviorHandler::class,
                    ],
                ],
                'registerCommandHandler',
                [
                    [
                        'registerCommandHandler',
                        CommandHandlerBehaviorCommand::class,
                        CommandHandlerBehaviorHandler::class,
                    ],
                ],
            ],
            [
                new ListenerResourceHandler(),
                ResourceType::Listeners->value,
                [
                    'type' => ResourceType::Listeners->value,
                    'listeners' => [
                        ListenerHandlerBehaviorEvent::class => [
                            ListenerHandlerBehaviorListenerOne::class,
                            ListenerHandlerBehaviorListenerTwo::class,
                        ],
                    ],
                ],
                'registerListener',
                [
                    [
                        'registerListener',
                        ListenerHandlerBehaviorEvent::class,
                        ListenerHandlerBehaviorListenerOne::class,
                    ],
                    [
                        'registerListener',
                        ListenerHandlerBehaviorEvent::class,
                        ListenerHandlerBehaviorListenerTwo::class,
                    ],
                ],
            ],
            [
                new MigrationResourceHandler(),
                ResourceType::Migrations->value,
                [
                    'type' => ResourceType::Migrations->value,
                    'paths' => [
                        'database/migrations/module-one',
                        'database/migrations/module-two',
                    ],
                ],
                'registerMigration',
                [
                    [
                        'registerMigration',
                        [
                            'database/migrations/module-one',
                            'database/migrations/module-two',
                        ],
                    ],
                ],
            ],
            [
                new PolicyResourceHandler(),
                ResourceType::Policies->value,
                [
                    'type' => ResourceType::Policies->value,
                    'policies' => [
                        PolicyHandlerBehaviorModel::class
                            => PolicyHandlerBehaviorPolicy::class,
                    ],
                ],
                'registerPolicy',
                [
                    [
                        'registerPolicy',
                        PolicyHandlerBehaviorModel::class,
                        PolicyHandlerBehaviorPolicy::class,
                    ],
                ],
            ],
            [
                new QueryResourceHandler(),
                ResourceType::Queries->value,
                [
                    'type' => ResourceType::Queries->value,
                    'queries' => [
                        QueryHandlerBehaviorQuery::class
                            => QueryHandlerBehaviorHandler::class,
                    ],
                ],
                'registerQuery',
                [
                    [
                        'registerQuery',
                        QueryHandlerBehaviorQuery::class,
                        QueryHandlerBehaviorHandler::class,
                    ],
                ],
            ],
            [
                new ServiceResourceHandler(),
                ResourceType::Services->value,
                [
                    'type' => ResourceType::Services->value,
                    'bindings' => [
                        ServiceHandlerBehaviorContract::class
                            => ServiceHandlerBehaviorImplementation::class,
                    ],
                ],
                'bind',
                [
                    [
                        'bind',
                        ServiceHandlerBehaviorContract::class,
                        ServiceHandlerBehaviorImplementation::class,
                    ],
                ],
            ],
            [
                new SingletonResourceHandler(),
                ResourceType::Singletons->value,
                [
                    'type' => ResourceType::Singletons->value,
                    'bindings' => [
                        SingletonHandlerBehaviorContract::class
                            => SingletonHandlerBehaviorImplementation::class,
                    ],
                ],
                'singleton',
                [
                    [
                        'singleton',
                        SingletonHandlerBehaviorContract::class,
                        SingletonHandlerBehaviorImplementation::class,
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('handlerProvider')]
    public function test_handler_supports_and_delegates_registration(
        CompiledResourceHandlerInterface $handler,
        string $type,
        array $resource,
        string $method,
        array $calls,
    ): void {
        $this->assertTrue($handler->supports($type));

        $registrar = Mockery::mock(ModuleRegistrarInterface::class);

        foreach ($calls as $call) {
            $arguments = array_slice($call, 1);

            $registrar
                ->shouldReceive($method)
                ->once()
                ->with(...$arguments);
        }

        $handler->register(
            $resource,
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

final class ActionHandlerBehaviorActionOne
{
}

final class ActionHandlerBehaviorActionTwo
{
}

final class CommandHandlerBehaviorCommand
{
}

final class CommandHandlerBehaviorSecondCommand
{
}

final class CommandHandlerBehaviorHandler
{
}

final class ListenerHandlerBehaviorEvent
{
}

final class ListenerHandlerBehaviorListenerOne
{
}

final class ListenerHandlerBehaviorListenerTwo
{
}

final class PolicyHandlerBehaviorModel
{
}

final class PolicyHandlerBehaviorPolicy
{
}

final class QueryHandlerBehaviorQuery
{
}

final class QueryHandlerBehaviorHandler
{
}

interface ServiceHandlerBehaviorContract
{
}

final class ServiceHandlerBehaviorImplementation
implements ServiceHandlerBehaviorContract
{
}

interface SingletonHandlerBehaviorContract
{
}

final class SingletonHandlerBehaviorImplementation
implements SingletonHandlerBehaviorContract
{
}
