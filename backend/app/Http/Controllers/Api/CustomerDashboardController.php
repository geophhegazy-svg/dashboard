<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Notification;

class CustomerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $customer = $request->user();

        // الاشتراك الحالي
        $subscription = Subscription::with('package')
            ->where('customer_id', $customer->id)
            ->latest()
            ->first();

        // آخر فاتورة
        $lastInvoice = Invoice::where('customer_id', $customer->id)
            ->latest()
            ->first();

        // آخر 3 فواتير
        $latestInvoices = Invoice::where('customer_id', $customer->id)
            ->latest()
            ->take(3)
            ->get([
                'invoice_number',
                'amount',
                'status',
                'paid_at'
            ]);

        // آخر 3 إشعارات
        $latestNotifications = Notification::where('customer_id', $customer->id)
            ->latest()
            ->take(3)
            ->get([
                'id',
                'title',
                'message',
                'is_read',
                'created_at'
            ]);

        // عدد الفواتير
        $totalInvoices = Invoice::where('customer_id', $customer->id)->count();

        // عدد الإشعارات غير المقروءة
        $unreadNotifications = Notification::where('customer_id', $customer->id)
            ->where('is_read', false)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Subscription Status
        |--------------------------------------------------------------------------
        */

        $daysRemaining = 0;
        $statusColor = 'red';
        $statusText = 'لا يوجد اشتراك';
        $expired = true;
        $expiresToday = false;

        if ($subscription) {

            $daysRemaining = now()->startOfDay()->diffInDays(
                Carbon::parse($subscription->end_date)->startOfDay(),
                false
            );

            $expired = $daysRemaining < 0;
            $expiresToday = $daysRemaining == 0;

            if ($subscription->status !== 'active') {

                $statusColor = 'red';
                $statusText = 'موقوف';
            } elseif ($expired) {

                $statusColor = 'red';
                $statusText = 'منتهي';
            } elseif ($expiresToday) {

                $statusColor = 'orange';
                $statusText = 'ينتهي اليوم';
            } elseif ($daysRemaining <= 3) {

                $statusColor = 'yellow';
                $statusText = 'ينتهي قريبًا';
            } else {

                $statusColor = 'green';
                $statusText = 'نشط';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
            ],

            'subscription' => $subscription ? [

                'status' => [

                    'code' => $subscription->status,

                    'text' => $statusText,

                    'color' => $statusColor,

                    'is_active' => $subscription->status === 'active',

                    'expired' => $expired,

                    'expires_today' => $expiresToday,

                ],

                'package' => [

                    'name' => optional($subscription->package)->name,

                    'price' => optional($subscription->package)->price,

                    'download_speed' => optional($subscription->package)->download_speed,

                    'upload_speed' => optional($subscription->package)->upload_speed,

                    'quota_gb' => optional($subscription->package)->quota_gb,

                ],
                'wallet' => [

                    'balance' => (float) $subscription->wallet_balance,

                    'currency' => 'EGP',

                    'can_renew' => $subscription->wallet_balance >= $subscription->monthly_price,

                ],

                'start_date' => $subscription->start_date,
                'end_date' => $subscription->end_date,
                'days_remaining' => $daysRemaining,

                'pppoe' => [
                    'username' => $subscription->pppoe_username,
                    'profile' => $subscription->mikrotik_profile,
                ],

            ] : null,

            'statistics' => [

                'total_invoices' => $totalInvoices,

                'paid_invoices' => Invoice::where('customer_id', $customer->id)
                    ->where('status', 'paid')
                    ->count(),

                'unpaid_invoices' => Invoice::where('customer_id', $customer->id)
                    ->where('status', 'unpaid')
                    ->count(),

                'unread_notifications' => $unreadNotifications,

            ],

            'last_invoice' => $lastInvoice ? [

                'invoice_number' => $lastInvoice->invoice_number,

                'amount' => (float) $lastInvoice->amount,

                'status' => $lastInvoice->status,

                'is_paid' => $lastInvoice->status === 'paid',

                'paid_at' => $lastInvoice->paid_at,

            ] : null,

            'recent_invoices' => $latestInvoices,

            'recent_notifications' => $latestNotifications,

            'actions' => [

                'renew' => $subscription
                    ? $subscription->wallet_balance >= $subscription->monthly_price
                    : false,

                'open_ticket' => true,

                'view_invoices' => true,

            ],

            'server_time' => now(),

        ]);
    }
}
