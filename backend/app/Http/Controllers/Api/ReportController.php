<?php

namespace App\Http\Controllers\Api;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Payment\Application\Queries\GetPaymentDashboardMetricsQuery;
use App\Modules\Payment\Application\Queries\GetRecentPaymentsQuery;
use App\Modules\Ticket\Application\Queries\GetTicketStatusMetricsQuery;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;
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
        $this->authorize('reports.dashboard');

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

            'tickets_open' => $this->queryDispatcher
                ->dispatch(new GetTicketStatusMetricsQuery())['open'],

            'revenue' => $paymentMetrics['total_revenue'],
        ]);
    }

    public function revenue()
    {
        $this->authorize('reports.revenue');

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
        $this->authorize('reports.invoices');

        $invoiceMetrics = $this->queryDispatcher->dispatch(
            new GetInvoiceStatusMetricsQuery()
        );

        return response()->json($invoiceMetrics);
    }
    public function inventory()
    {
        $this->authorize('reports.inventory');

        return response()->json(['low_stock' => Inventory::whereColumn('quantity', '<=', 'minimum_quantity')->get(),]);
    }
    public function tickets()
    {
        $this->authorize('reports.tickets');

        return response()->json(
            $this->queryDispatcher->dispatch(
                new GetTicketStatusMetricsQuery()
            )
        );
    }
}
