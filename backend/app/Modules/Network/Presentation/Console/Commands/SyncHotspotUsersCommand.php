<?php

declare(strict_types=1);

namespace App\Modules\Network\Presentation\Console\Commands;

use App\Modules\Network\Application\Actions\SyncHotspotUsersAction;
use Illuminate\Console\Command;

final class SyncHotspotUsersCommand extends Command
{
    protected $signature = 'mikrotik:sync-hotspot
                            {--device= : جهاز معين}';

    protected $description =
        'مزامنة مستخدمي Hotspot من MikroTik';

    public function __construct(
        private readonly SyncHotspotUsersAction $action,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('🔄 بدء مزامنة مستخدمي Hotspot...');

        $deviceId = $this->option('device');

        $result = $this->action->execute(
            $deviceId !== null ? (int) $deviceId : null,
        );

        if (! $result) {
            $this->error('❌ لا توجد أجهزة MikroTik نشطة');

            return self::FAILURE;
        }

        $this->info('✅ اكتملت مزامنة Hotspot بنجاح');

        return self::SUCCESS;
    }
}
