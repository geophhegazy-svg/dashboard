<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Ticket;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        // الاشتراك الحالي
        $subscription = Subscription::where('customer_id', $customer->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        // الفواتير
        $invoices = Invoice::where('customer_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        // التذاكر
        $tickets = Ticket::where('customer_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('customer', 'subscription', 'invoices', 'tickets'));
    }
}
