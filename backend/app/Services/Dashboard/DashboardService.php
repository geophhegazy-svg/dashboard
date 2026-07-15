<?php

declare(strict_types=1);

namespace App\Services\Dashboard;

use App\Models\Customer;
use App\Models\HotspotSubscription;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Payment;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;

class DashboardService
{
    public function getDashboardData(): array
    {
        return [
            'business' => $this->getBusinessMetrics(),
            'customers' => $this->getCustomerMetrics(),
            'subscriptions' => $this->getSubscriptionMetrics(),
            'financial' => $this->getFinancialMetrics(),
            'network' => $this->getNetworkMetrics(),
        ];
    }

    private function getBusinessMetrics(): array
    {
        return [
            'total_customers' => Customer::count(),
            'packages_count' => Package::count(),
        ];
    }

    private function getCustomerMetrics(): array
    {
        return [
            'active' => Customer::whereHas('subscriptions', function ($query) {
                $query->where('status', SubscriptionStatus::ACTIVE->value);
            })->count(),

            'expired' => Customer::whereHas('subscriptions', function ($query) {
                $query->where('status', SubscriptionStatus::EXPIRED->value);
            })->count(),

            'suspended' => Customer::whereHas('subscriptions', function ($query) {
                $query->where('status', SubscriptionStatus::SUSPENDED->value);
            })->count(),
        ];
    }

    private function getSubscriptionMetrics(): array
    {
        return [
            'pppoe' => [
                'active' => Subscription::where(
                    'status',
                    SubscriptionStatus::ACTIVE->value
                )->count(),

                'expired' => Subscription::where(
                    'status',
                    SubscriptionStatus::EXPIRED->value
                )->count(),

                'suspended' => Subscription::where(
                    'status',
                    SubscriptionStatus::SUSPENDED->value
                )->count(),
            ],

            'hotspot' => [
                'active' => HotspotSubscription::where(
                    'status',
                    SubscriptionStatus::ACTIVE->value
                )->count(),

                'expired' => HotspotSubscription::where(
                    'status',
                    SubscriptionStatus::EXPIRED->value
                )->count(),

                'suspended' => HotspotSubscription::where(
                    'status',
                    SubscriptionStatus::SUSPENDED->value
                )->count(),
            ],
        ];
    }

    private function getFinancialMetrics(): array
    {
        return [
            'total_invoices' => Invoice::count(),

            'total_revenue' => Payment::sum('amount'),

            'monthly_revenue' => Payment::whereMonth(
                'payment_date',
                now()->month
            )->sum('amount'),
        ];
    }

    private function getNetworkMetrics(): array
    {
        return [
            'router' => null,
            'pppoe_online' => 0,
            'hotspot_online' => 0,
            'dhcp_leases' => 0,
        ];
    }
}
