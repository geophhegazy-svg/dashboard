<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class CustomerInvoiceController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $invoices = Invoice::query()
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view(
            'customer.invoices',
            compact('invoices')
        );
    }

    public function show(
        int $id
    ) {
        $customer = Auth::guard('customer')->user();

        $invoice = Invoice::query()
            ->where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        return view(
            'customer.invoice-detail',
            compact('invoice')
        );
    }
}
