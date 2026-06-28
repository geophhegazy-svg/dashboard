<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Package;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([

            // Customers
            'total_customers' =>
            Customer::count(),

            'active_customers' =>
            Customer::whereHas('subscriptions', function ($q) {
                $q->where('status', 'active');
            })->count(),

            'expired_customers' =>
            Customer::whereHas('subscriptions', function ($q) {
                $q->where('status', 'expired');
            })->count(),

            'suspended_customers' =>
            Customer::whereHas('subscriptions', function ($q) {
                $q->where('status', 'suspended');
            })->count(),

            // Packages
            'packages_count' =>
            Package::count(),

            // Subscriptions
            'active_subscriptions' =>
            Subscription::where('status', 'active')->count(),

            'expired_subscriptions' =>
            Subscription::where('status', 'expired')->count(),

            'suspended_subscriptions' =>
            Subscription::where('status', 'suspended')->count(),

            // Financial
            'total_invoices' =>
            Invoice::count(),

            'total_payments' =>
            Payment::sum('amount'),

            'monthly_revenue' =>
            Payment::whereMonth(
                'payment_date',
                now()->month
            )->sum('amount'),

            'total_revenue' =>
            Payment::sum('amount'),
        ]);
    }
}
