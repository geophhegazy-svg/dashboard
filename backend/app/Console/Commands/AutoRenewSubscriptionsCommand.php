<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Subscription\SubscriptionSchedulerService;
use Illuminate\Console\Command;

class AutoRenewSubscriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'subscriptions:auto-renew';

    /**
     * The console command description.
     */
    protected $description = 'Automatically renew eligible subscriptions from customer wallet';

    public function __construct(
        private readonly SubscriptionSchedulerService $scheduler,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $count = $this->scheduler->autoRenew();

        $this->info("{$count} subscription(s) renewed successfully.");

        return self::SUCCESS;
    }
}
