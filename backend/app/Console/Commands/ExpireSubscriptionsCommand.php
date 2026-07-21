<?php
// backend/app/Console/Commands/ExpireSubscriptionsCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Subscription\Application\Services\SubscriptionService;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;

class ExpireSubscriptionsCommand extends Command
{
    protected $signature = 'subscriptions:expire';
    protected $description = 'إنهاء الاشتراكات المنتهية';

    protected $subscriptionService;
    protected $subscriptionRepository;

    public function __construct(
        SubscriptionService $subscriptionService,
        SubscriptionRepositoryInterface $subscriptionRepository  // 🔥 استخدام Interface
    ) {
        parent::__construct();
        $this->subscriptionService = $subscriptionService;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function handle()
    {
        $this->info('🔄 جارٍ إنهاء الاشتراكات المنتهية...');

        // منطق إنهاء الاشتراكات...

        $this->info('✅ تم إنهاء الاشتراكات المنتهية بنجاح');
    }
}
