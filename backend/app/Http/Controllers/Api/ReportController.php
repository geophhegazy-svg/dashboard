<?php

namespace App\Http\Controllers\Api;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Payment\Application\Queries\GetPaymentDashboardMetricsQuery;
use App\Modules\Payment\Application\Queries\GetRecentPaymentsQuery;
use App\Models\Ticket;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Invoice\Application\Queries\GetInvoiceDashboardMetricsQuery;
use App\Modules\Invoice\Application\Queries\GetInvoiceStatusMetricsQuery;

class ReportController extends Controller
{
    public function __construct(
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function dashboard()
    {
        $invoiceMetrics = $this->queryDispatcher->dispatch(
            new GetInvoiceDashboardMetricsQuery()
        );

        $paymentMetrics = $this->queryDispatcher->dispatch(
            new GetPaymentDashboardMetricsQuery()
        );

        return response()->json([
            'customers' => Customer::count(),

            'invoices' => $invoiceMetrics['total_invoices'],

            'paid_invoices' => $invoiceMetrics['paid_invoices'],

            'pending_invoices' => $invoiceMetrics['pending_invoices'],

            'payments' => $paymentMetrics['total_payments'],

            'tickets_open' => Ticket::where(
                'status',
                'open'
            )->count(),

            'revenue' => $paymentMetrics['total_revenue'],
        ]);
    }

    public function revenue()
    {
        $paymentMetrics = $this->queryDispatcher->dispatch(
            new GetPaymentDashboardMetricsQuery()
        );

        $payments = $this->queryDispatcher->dispatch(
            new GetRecentPaymentsQuery()
        );

        return response()->json([
            'total_revenue' => $paymentMetrics['total_revenue'],
            'payments' => $payments,
        ]);
    }

    public function invoices()
    {
        $invoiceMetrics = $this->queryDispatcher->dispatch(
            new GetInvoiceStatusMetricsQuery()
        );

        return response()->json($invoiceMetrics);
    }
    public function inventory()
    {
        return response()->json(['low_stock' => Inventory::whereColumn('quantity', '<=', 'minimum_quantity')->get(),]);
    }
    public function tickets()
    {
        return response()->json(['open' => Ticket::where('status', 'open')->count(), 'closed' => Ticket::where('status', 'closed')->count(), 'pending' => Ticket::where('status', 'pending')->count(),]);
    }
}
