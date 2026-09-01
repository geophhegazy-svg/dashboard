<?php

declare(strict_types=1);

namespace App\Modules\Usage\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Usage\Application\Commands\SyncUsageSnapshotsCommand;
use App\Modules\Usage\Application\Commands\Handlers\SyncUsageSnapshotsCommandHandler;
use App\Modules\Usage\Presentation\Console\Commands\SyncUsageSnapshotsCommand as ConsoleSyncUsageSnapshotsCommand;

final class UsageModule extends Module
{
    public function name(): string
    {
        return 'Usage';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Network\Kernel\NetworkModule::class,
            \App\Modules\Subscription\Kernel\SubscriptionModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()
            ->commands([
                ConsoleSyncUsageSnapshotsCommand::class,
            ])
            ->commandHandlers([
                SyncUsageSnapshotsCommand::class =>
                    SyncUsageSnapshotsCommandHandler::class,
            ])
            ->schedules(function ($schedule): void {
                $schedule->command('usage:sync')
                    ->everyFifteenMinutes()
                    ->withoutOverlapping();
            });
    }
}
