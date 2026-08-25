<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Subscription\Application\Orchestrators\AutoGraceSubscriptionsOrchestratorInterface;
use Illuminate\Console\Command;

final class AutoGraceSubscriptionsCommand extends Command
{
    protected $signature = 'subscriptions:auto-grace';

    protected $description = 'إدخال الاشتراكات المستحقة في فترة السماح';

    public function __construct(
        private readonly AutoGraceSubscriptionsOrchestratorInterface $orchestrator,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $count = $this->orchestrator->execute();

        $this->info(
            sprintf(
                'تم إدخال %d اشتراك في فترة السماح.',
                $count,
            )
        );

        return self::SUCCESS;
    }
}
