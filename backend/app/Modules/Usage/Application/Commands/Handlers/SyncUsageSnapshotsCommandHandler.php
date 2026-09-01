<?php

declare(strict_types=1);

namespace App\Modules\Usage\Application\Commands\Handlers;

use App\Modules\Usage\Application\Actions\SyncUsageSnapshotsAction;
use App\Modules\Usage\Application\Commands\SyncUsageSnapshotsCommand;

final readonly class SyncUsageSnapshotsCommandHandler
{
    public function __construct(
        private SyncUsageSnapshotsAction $action,
    ) {}

    public function handle(
        SyncUsageSnapshotsCommand $command,
    ): int {
        return $this->action->execute();
    }
}
