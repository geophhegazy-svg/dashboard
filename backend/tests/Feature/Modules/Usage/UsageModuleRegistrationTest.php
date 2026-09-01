<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Usage;

use App\Core\CommandBus\CommandRegistry;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Resources\CommandHandlerResource;
use App\Core\Kernel\Resources\CommandResource;
use App\Core\Kernel\Resources\ScheduleResource;
use App\Modules\Usage\Application\Commands\SyncUsageSnapshotsCommand;
use App\Modules\Usage\Application\Commands\Handlers\SyncUsageSnapshotsCommandHandler;
use App\Modules\Usage\Kernel\UsageModule;
use App\Modules\Usage\Presentation\Console\Commands\SyncUsageSnapshotsCommand as ConsoleCommand;
use Illuminate\Console\Scheduling\Schedule;
use Tests\TestCase;

final class UsageModuleRegistrationTest extends TestCase
{
    public function test_usage_module_declares_console_command(): void
    {
        $resources = $this->app
            ->make(UsageModule::class)
            ->manifest()
            ->resources()
            ->all();

        $commandResources = array_values(
            array_filter(
                $resources,
                static fn ($resource): bool =>
                    $resource instanceof CommandResource,
            ),
        );

        self::assertCount(1, $commandResources);

        self::assertSame(
            [
                ConsoleCommand::class,
            ],
            $commandResources[0]->commands(),
        );
    }

    public function test_usage_module_declares_command_handler(): void
    {
        $resources = $this->app
            ->make(UsageModule::class)
            ->manifest()
            ->resources()
            ->all();

        $handlerResources = array_values(
            array_filter(
                $resources,
                static fn ($resource): bool =>
                    $resource instanceof CommandHandlerResource,
            ),
        );

        self::assertCount(1, $handlerResources);

        $compiled = $handlerResources[0]->compile();

        self::assertSame(
            [
                SyncUsageSnapshotsCommand::class =>
                    SyncUsageSnapshotsCommandHandler::class,
            ],
            $compiled['handlers'],
        );
    }

    public function test_usage_module_declares_schedule(): void
    {
        $resources = $this->app
            ->make(UsageModule::class)
            ->manifest()
            ->resources()
            ->all();

        $scheduleResources = array_values(
            array_filter(
                $resources,
                static fn ($resource): bool =>
                    $resource instanceof ScheduleResource,
            ),
        );

        self::assertCount(1, $scheduleResources);

        $schedule = $this->app->make(Schedule::class);
        $before = count($schedule->events());

        $scheduleResources[0]->register(
            $this->app->make(ModuleRegistrarInterface::class),
        );

        self::assertCount(
            $before + 1,
            $schedule->events(),
        );

        $usageEvents = array_values(
            array_filter(
                $schedule->events(),
                static fn ($event): bool =>
                    str_contains(
                        (string) $event->command,
                        'usage:sync',
                    ),
            ),
        );

        self::assertNotEmpty($usageEvents);

        $matchingEvents = array_values(
            array_filter(
                $usageEvents,
                static fn ($event): bool =>
                    $event->expression === '*/15 * * * *',
            ),
        );

        self::assertNotEmpty($matchingEvents);
    }

    public function test_usage_command_handler_is_registered(): void
    {
        $descriptor = $this->app
            ->make(CommandRegistry::class)
            ->get(
                SyncUsageSnapshotsCommand::class,
            );

        self::assertNotNull($descriptor);

        self::assertSame(
            SyncUsageSnapshotsCommandHandler::class,
            $descriptor->handler,
        );
    }
}
