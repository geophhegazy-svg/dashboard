<?php
// backend/app/Actions/Subscription/ActivateSubscriptionAction.php

namespace App\Actions\Subscription;

use App\Contracts\MikrotikServiceInterface;  // 🔥 استخدام الـ Interface
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class ActivateSubscriptionAction
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService,  // ✅ Interface
    ) {}

    public function execute(Customer $customer, Subscription $subscription): bool
    {
        // منطق التفعيل...
    }
}
