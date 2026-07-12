<?php
use IlluminateSupportFacadesAuth;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class CustomerInvoiceController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $invoices = Invoice::where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view('customer.invoices', compact('invoices'));
    }

    public function show($id)
    {
        $customer = Auth::guard('customer')->user();
        $invoice = Invoice::where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('customer.invoice-detail', compact('invoice'));
    }
}
