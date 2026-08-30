<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Presentation\Console\Commands;

use App\Modules\Subscription\Application\Orchestrators\AutoExpireSubscriptionsOrchestratorInterface;
use Illuminate\Console\Command;

final class AutoExpireSubscriptionsCommand extends Command
{
    protected $signature = 'subscriptions:auto-expire';

    protected $description = 'إنهاء الاشتراكات المنتهية تلقائياً';

    public function __construct(
        private readonly AutoExpireSubscriptionsOrchestratorInterface $orchestrator,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $count = $this->orchestrator->execute();

        $this->info(
            sprintf(
                'تم إنهاء %d اشتراك منتهٍ.',
                $count,
            )
        );

        return self::SUCCESS;
    }
}
