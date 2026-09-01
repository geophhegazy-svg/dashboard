<?php

declare(strict_types=1);

namespace App\Modules\Usage\Presentation\Console\Commands;

use App\Core\CommandBus\CommandDispatcher;
use App\Modules\Usage\Application\Commands\SyncUsageSnapshotsCommand as ApplicationCommand;
use Illuminate\Console\Command;

final class SyncUsageSnapshotsCommand extends Command
{
    protected $signature = 'usage:sync';

    protected $description = 'مزامنة لقطات استهلاك عملاء PPPoE و Hotspot';

    public function __construct(
        private readonly CommandDispatcher $dispatcher,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('🔄 بدء مزامنة الاستهلاك...');

        $totalSnapshots = $this->dispatcher->dispatch(
            new ApplicationCommand(),
        );

        $this->info(
            "✅ تم تسجيل {$totalSnapshots} لقطة استهلاك بنجاح",
        );

        return self::SUCCESS;
    }
}
