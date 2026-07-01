<?php

declare(strict_types=1);

namespace App\Services\Dashboard;

use App\Models\Customer;
use App\Models\HotspotSubscription;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;

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
                $query->where('status', 'active');
            })->count(),

            'expired' => Customer::whereHas('subscriptions', function ($query) {
                $query->where('status', 'expired');
            })->count(),

            'suspended' => Customer::whereHas('subscriptions', function ($query) {
                $query->where('status', 'suspended');
            })->count(),
        ];
    }

    private function getSubscriptionMetrics(): array
    {
        return [
            'pppoe' => [
                'active' => Subscription::where('status', 'active')->count(),
                'expired' => Subscription::where('status', 'expired')->count(),
                'suspended' => Subscription::where('status', 'suspended')->count(),
            ],

            'hotspot' => [
                'active' => HotspotSubscription::where('status', 'active')->count(),
                'expired' => HotspotSubscription::where('status', 'expired')->count(),
                'suspended' => HotspotSubscription::where('status', 'suspended')->count(),
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
