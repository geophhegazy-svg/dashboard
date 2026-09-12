<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Network;

use App\Core\Kernel\Resources\ActionResource;
use App\Core\Kernel\Resources\CommandResource;
use App\Core\Kernel\Resources\ScheduleResource;
use App\Modules\Network\Application\Actions\CreateDhcpLeaseAction;
use App\Modules\Network\Application\Actions\UpdateDhcpLeaseAction;
use App\Modules\Network\Application\Actions\DeleteDhcpLeaseAction;
use App\Modules\Network\Application\Actions\CreateFirewallRuleAction;
use App\Modules\Network\Application\Actions\UpdateFirewallRuleAction;
use App\Modules\Network\Application\Actions\DeleteFirewallRuleAction;
use App\Modules\Network\Application\Actions\CreateQueueAction;
use App\Modules\Network\Application\Actions\UpdateQueueAction;
use App\Modules\Network\Application\Actions\ToggleQueueAction;
use App\Modules\Network\Application\Actions\DeleteQueueAction;
use App\Modules\Network\Application\Actions\SyncHotspotUsersAction;
use App\Modules\Network\Application\Actions\SyncMikroTikUsersAction;
use App\Modules\Network\Kernel\NetworkModule;
use App\Modules\Network\Presentation\Console\Commands\SyncHotspotUsersCommand;
use App\Modules\Network\Presentation\Console\Commands\SyncMikroTikCommand;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use Illuminate\Console\Scheduling\Schedule;
use Tests\TestCase;

final class NetworkModuleRegistrationTest extends TestCase
{
    public function test_network_module_declares_actions(): void
    {
        $resources = $this->app
            ->make(NetworkModule::class)
            ->manifest()
            ->resources()
            ->all();

        $actionResources = array_values(
            array_filter(
                $resources,
                static fn ($resource): bool =>
                    $resource instanceof ActionResource,
            ),
        );

        self::assertCount(1, $actionResources);

        self::assertSame(
            [
                CreateDhcpLeaseAction::class,
                UpdateDhcpLeaseAction::class,
                DeleteDhcpLeaseAction::class,

                CreateFirewallRuleAction::class,
                UpdateFirewallRuleAction::class,
                DeleteFirewallRuleAction::class,

                CreateQueueAction::class,
                UpdateQueueAction::class,
                ToggleQueueAction::class,
                DeleteQueueAction::class,

                SyncMikroTikUsersAction::class,
                SyncHotspotUsersAction::class,
            ],
            $actionResources[0]->compile()['actions'],
        );
    }

    public function test_network_module_declares_sync_console_commands(): void
    {
        $resources = $this->app
            ->make(NetworkModule::class)
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
                SyncMikroTikCommand::class,
                SyncHotspotUsersCommand::class,
            ],
            $commandResources[0]->commands(),
        );
    }

    public function test_network_module_declares_sync_schedules(): void
    {
        $resources = $this->app
            ->make(NetworkModule::class)
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
            $before + 2,
            $schedule->events(),
        );

        $newEvents = array_slice(
            $schedule->events(),
            $before,
        );

        $commands = array_map(
            static fn ($event): string => (string) $event->command,
            $newEvents,
        );

        self::assertSame(
            [
                "'/usr/local/bin/php' 'artisan' mikrotik:sync-hotspot",
                "'/usr/local/bin/php' 'artisan' mikrotik:sync",
            ],
            $commands,
        );

        $expressions = array_map(
            static fn ($event): string => $event->expression,
            $newEvents,
        );

        self::assertSame(
            [
                '*/5 * * * *',
                '*/5 * * * *',
            ],
            $expressions,
        );
    }
}
