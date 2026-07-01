<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Subscription\SubscriptionService;
use App\Models\Subscription;

class ExpireSubscriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     */
    protected $description = 'Expire subscriptions that reached their end date';

    public function __construct(
        private readonly SubscriptionService $subscriptionService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $subscriptions = Subscription::query()
            ->whereDate('end_date', '<=', today())
            ->where('status', '!=', 'expired')
            ->get();

        if ($subscriptions->isEmpty()) {

            $this->info('No expired subscriptions found.');

            return self::SUCCESS;
        }

        $success = 0;
        $failed = 0;

        foreach ($subscriptions as $subscription) {

            try {

                $this->subscriptionService->expire($subscription);

                $success++;

                $this->info(
                    "✔ Subscription #{$subscription->id} expired."
                );
            } catch (\Throwable $e) {

                $failed++;

                report($e);

                $this->error(
                    "✖ Subscription #{$subscription->id} failed."
                );
            }
        }

        $this->newLine();

        $this->info("Processed : {$subscriptions->count()}");
        $this->info("Succeeded : {$success}");
        $this->info("Failed    : {$failed}");

        return self::SUCCESS;
    }
}
