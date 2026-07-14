<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Services\Subscription\SubscriptionExpirationService;
use Illuminate\Console\Command;

class SubscriptionsAutoExpireCommand extends Command
{
    /**
     * اسم الأمر.
     */
    protected $signature = 'subscriptions:auto-expire';

    /**
     * وصف الأمر.
     */
    protected $description = 'Expire subscriptions after grace period ends';

    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly SubscriptionExpirationService $expirationService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $count = 0;

        $subscriptions = $this->subscriptions->findEligibleForExpiration();

        foreach ($subscriptions as $subscription) {

            $this->expirationService->expirePppoe(
                $subscription
            );

            $count++;
        }

        $this->info(
            "{$count} subscription(s) expired successfully."
        );

        return self::SUCCESS;
    }
}
