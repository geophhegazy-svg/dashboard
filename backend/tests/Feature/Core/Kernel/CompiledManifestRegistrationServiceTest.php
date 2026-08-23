<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Contracts\ContainerInterface;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Kernel\Compiler\CompiledModule;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Contracts\CompiledResourceHandlerInterface;
use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Events\ModuleBooted;
use App\Core\Kernel\Events\ModuleBooting;
use App\Core\Kernel\Registration\CompiledManifestRegistrationService;
use App\Core\Kernel\Registration\CompiledResourceRegistrar;
use App\Core\Kernel\Registration\RuntimeResourceRegistrar;
use App\Core\Kernel\Resources\ResourceType;
use App\Core\Kernel\Registration\Handlers\ListenerResourceHandler;
use App\Core\EventBus\EventRegistry;
use Mockery;
use Tests\TestCase;

final class CompiledManifestRegistrationServiceTest extends TestCase
{
    public function test_it_registers_compiled_listener_resource(): void
    {
        $module = new CompiledManifestRegistrationServiceModule();

        $container = Mockery::mock(
            ContainerInterface::class,
        );

        $container
            ->shouldReceive('make')
            ->once()
            ->with(CompiledManifestRegistrationServiceModule::class)
            ->andReturn($module);

        $events = Mockery::mock(
            EventDispatcherInterface::class,
        );

        $events
            ->shouldReceive('dispatch')
            ->twice()
            ->andReturnNull();

        $resourceRegistrar = new CompiledResourceRegistrar([
            new ListenerResourceHandler(),
        ]);

        $runtimeRegistrar = new RuntimeResourceRegistrar();

        $moduleRegistrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $service = new CompiledManifestRegistrationService(
            $resourceRegistrar,
            $runtimeRegistrar,
            $events,
            $container,
        );

        $manifest = new CompiledModuleManifest([
            new CompiledModule(
                class: CompiledManifestRegistrationServiceModule::class,
                name: 'compiled-listener-test',
                dependencies: [],
                resources: [
                    [
                        'type' => ResourceType::Listeners->value,
                        'listeners' => [
                            CompiledManifestListenerEvent::class => [
                                CompiledManifestListener::class,
                            ],
                        ],
                    ],
                ],
            ),
        ]);

        $service->register(
            $manifest,
            $moduleRegistrar,
        );

        self::assertSame(
            [CompiledManifestListener::class],
            $this->app
                ->make(EventRegistry::class)
                ->listenersFor(
                    new CompiledManifestListenerEvent(),
                ),
        );
    }

    public function test_it_registers_compiled_resources_with_module_lifecycle_events(): void
    {
        $timeline = [];
        $bootingModule = null;
        $bootedModule = null;

        $module = Mockery::mock(ModuleContract::class);

        $module
            ->shouldReceive('manifest')
            ->once()
            ->andReturn(
                ModuleManifest::make()->configs([
                    'phase_8_7_runtime' => 'registered',
                ]),
            );

        $container = Mockery::mock(
            ContainerInterface::class
        );

        $container
            ->shouldReceive('make')
            ->once()
            ->with(CompiledManifestRegistrationServiceModule::class)
            ->andReturn($module);

        $events = Mockery::mock(
            EventDispatcherInterface::class
        );

        $events
            ->shouldReceive('dispatch')
            ->twice()
            ->ordered()
            ->andReturnUsing(
                static function (object $event) use (
                    &$timeline,
                    &$bootingModule,
                    &$bootedModule,
                ): void {
                    $timeline[] = $event::class;

                    if ($event instanceof ModuleBooting) {
                        $bootingModule = $event->module;
                    }

                    if ($event instanceof ModuleBooted) {
                        $bootedModule = $event->module;
                    }
                },
            );

        $handler = new class($timeline) implements CompiledResourceHandlerInterface {
            /**
             * @param list<string> $timeline
             */
            public function __construct(
                private array &$timeline,
            ) {}

            public function supports(
                string $type,
            ): bool {
                return $type === ResourceType::Commands->value;
            }

            /**
             * @param array<string,mixed> $resource
             */
            public function register(
                array $resource,
                ModuleRegistrarInterface $registrar,
            ): void {
                $this->timeline[] = 'resource.registered';

                $registrar->registerCommand(
                    $resource['commands'][0],
                );
            }
        };

        $resourceRegistrar = new CompiledResourceRegistrar([
            $handler,
        ]);

        $runtimeRegistrar = new RuntimeResourceRegistrar();

        $moduleRegistrar = Mockery::mock(
            ModuleRegistrarInterface::class
        );

        $moduleRegistrar
            ->shouldReceive('registerConfig')
            ->once()
            ->with([
                'phase_8_7_runtime' => 'registered',
            ])
            ->ordered();

        $moduleRegistrar
            ->shouldReceive('registerCommand')
            ->once()
            ->with(CompiledManifestRegistrationServiceCommand::class)
            ->ordered();

        $service = new CompiledManifestRegistrationService(
            $resourceRegistrar,
            $runtimeRegistrar,
            $events,
            $container,
        );

        $manifest = new CompiledModuleManifest([
            new CompiledModule(
                class: CompiledManifestRegistrationServiceModule::class,
                name: 'compiled-registration-test',
                dependencies: [],
                resources: [
                    [
                        'type' => ResourceType::Commands->value,
                        'commands' => [
                            CompiledManifestRegistrationServiceCommand::class,
                        ],
                    ],
                ],
            ),
        ]);

        $service->register(
            $manifest,
            $moduleRegistrar,
        );

        self::assertSame(
            [
                ModuleBooting::class,
                'resource.registered',
                ModuleBooted::class,
            ],
            $timeline,
        );

        self::assertSame(
            $module,
            $bootingModule,
        );

        self::assertSame(
            $module,
            $bootedModule,
        );
    }

    public function test_it_registers_modules_in_compiled_manifest_order(): void
    {
        $timeline = [];

        $first = new CompiledManifestRegistrationServiceModule();
        $second = new CompiledManifestRegistrationServiceSecondModule();

        $container = Mockery::mock(
            ContainerInterface::class,
        );

        $container
            ->shouldReceive('make')
            ->once()
            ->with(CompiledManifestRegistrationServiceModule::class)
            ->andReturn($first);

        $container
            ->shouldReceive('make')
            ->once()
            ->with(CompiledManifestRegistrationServiceSecondModule::class)
            ->andReturn($second);

        $events = Mockery::mock(
            EventDispatcherInterface::class,
        );

        $events
            ->shouldReceive('dispatch')
            ->times(4)
            ->ordered()
            ->andReturnUsing(
                static function (object $event) use (&$timeline): void {
                    if ($event instanceof ModuleBooting) {
                        $timeline[] = 'booting:' . $event->module::class;
                    }

                    if ($event instanceof ModuleBooted) {
                        $timeline[] = 'booted:' . $event->module::class;
                    }
                },
            );

        $resourceRegistrar = new CompiledResourceRegistrar([]);

        $runtimeRegistrar = new RuntimeResourceRegistrar();

        $moduleRegistrar = Mockery::mock(
            ModuleRegistrarInterface::class,
        );

        $service = new CompiledManifestRegistrationService(
            $resourceRegistrar,
            $runtimeRegistrar,
            $events,
            $container,
        );

        $manifest = new CompiledModuleManifest([
            new CompiledModule(
                class: CompiledManifestRegistrationServiceModule::class,
                name: 'first',
                dependencies: [],
                resources: [],
            ),
            new CompiledModule(
                class: CompiledManifestRegistrationServiceSecondModule::class,
                name: 'second',
                dependencies: [
                    CompiledManifestRegistrationServiceModule::class,
                ],
                resources: [],
            ),
        ]);

        $service->register(
            $manifest,
            $moduleRegistrar,
        );

        self::assertSame(
            [
                'booting:' . CompiledManifestRegistrationServiceModule::class,
                'booted:' . CompiledManifestRegistrationServiceModule::class,
                'booting:' . CompiledManifestRegistrationServiceSecondModule::class,
                'booted:' . CompiledManifestRegistrationServiceSecondModule::class,
            ],
            $timeline,
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}

final class CompiledManifestRegistrationServiceModule implements ModuleContract
{
    public function name(): string
    {
        return 'compiled-registration-test';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): \App\Core\Kernel\ModuleManifest
    {
        return \App\Core\Kernel\ModuleManifest::make();
    }
}

final class CompiledManifestRegistrationServiceCommand
{
}

final class CompiledManifestRegistrationServiceSecondModule implements ModuleContract
{
    public function name(): string
    {
        return 'compiled-registration-second-test';
    }

    public function dependencies(): array
    {
        return [
            CompiledManifestRegistrationServiceModule::class,
        ];
    }

    public function manifest(): \App\Core\Kernel\ModuleManifest
    {
        return \App\Core\Kernel\ModuleManifest::make();
    }
}



final class CompiledManifestListenerEvent implements \App\Core\EventBus\Contracts\EventContract
{
}

final class CompiledManifestListener
{
}
