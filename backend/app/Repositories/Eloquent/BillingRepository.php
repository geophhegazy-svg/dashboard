<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\BillingRepositoryInterface;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

class BillingRepository implements BillingRepositoryInterface
{
    public function subscriptionsDueForBilling(): Collection
    {
        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->where('status', 'active')
            ->whereDate('next_invoice_date', '<=', today())
            ->get();
    }

    public function subscriptionsDueForSuspension(): Collection
    {
        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->where('status', 'active')
            ->whereDate('grace_until', '<', today())
            ->get();
    }

    public function subscriptionsDueForExpiration(): Collection
    {
        return Subscription::query()
            ->with([
                'customer',
                'package',
            ])
            ->where('status', 'suspended')
            ->whereDate('end_date', '<', today())
            ->get();
    }
}
