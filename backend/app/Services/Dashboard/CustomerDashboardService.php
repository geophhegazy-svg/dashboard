<?php

declare(strict_types=1);

namespace App\Services\Dashboard;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Subscription;
use App\Services\Usage\UsageService;
use Carbon\Carbon;

class CustomerDashboardService
{
    public function __construct(
        private readonly UsageService $usageService
    ) {}

    public function getDashboardData(Customer $customer): array
    {
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

        [$daysRemaining, $statusColor, $statusText, $expired, $expiresToday] =
            $this->resolveSubscriptionStatus($subscription);

        return [

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

            'usage' => $this->usageService->getUsageForCustomer($customer),

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

        ];
    }

    /**
     * بيحسب حالة الاشتراك (نشط / منتهي / هينتهي قريب) والألوان والنصوص المرتبطة بيها.
     *
     * @return array{0: int, 1: string, 2: string, 3: bool, 4: bool}
     */
    private function resolveSubscriptionStatus(?Subscription $subscription): array
    {
        $daysRemaining = 0;
        $statusColor = 'red';
        $statusText = 'لا يوجد اشتراك';
        $expired = true;
        $expiresToday = false;

        if (!$subscription) {
            return [$daysRemaining, $statusColor, $statusText, $expired, $expiresToday];
        }

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

        return [$daysRemaining, $statusColor, $statusText, $expired, $expiresToday];
    }
}
