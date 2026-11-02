<?php

declare(strict_types=1);

namespace App\Modules\Network\Presentation\Console\Commands;

use App\Modules\Network\Application\Actions\SyncMikroTikAction;
use Illuminate\Console\Command;

final class SyncMikroTikCommand extends Command
{
    protected $signature = 'mikrotik:sync
                            {--device= : جهاز معين}
                            {--auto : تشغيل تلقائي}';

    protected $description =
        'مزامنة MikroTik الشاملة';

    public function __construct(
        private readonly SyncMikroTikAction $action,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('🔄 بدء مزامنة MikroTik الشاملة...');

        $deviceId = $this->option('device');

        $result = $this->action->execute(
            $deviceId !== null ? (int) $deviceId : null,
        );

        if (! $result) {
            $this->error('❌ لا توجد أجهزة MikroTik نشطة');

            return self::FAILURE;
        }

        $this->info('✅ اكتملت مزامنة MikroTik الشاملة بنجاح');

        return self::SUCCESS;
    }
}
