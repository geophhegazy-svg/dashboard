<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Subscription\Application\Orchestrators\AutoRenewSubscriptionsOrchestratorInterface;
use Illuminate\Console\Command;

final class AutoRenewSubscriptionsCommand extends Command
{
    protected $signature = 'subscriptions:auto-renew';

    protected $description = 'تجديد الاشتراكات المستحقة تلقائياً';

    public function __construct(
        private readonly AutoRenewSubscriptionsOrchestratorInterface $orchestrator,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $count = $this->orchestrator->execute();

        $this->info(
            sprintf(
                'تم تجديد %d اشتراك تلقائياً.',
                $count,
            )
        );

        return self::SUCCESS;
    }
}
