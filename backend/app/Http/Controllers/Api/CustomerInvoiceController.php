<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerInvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CustomerInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $customer = $request->user();

        $invoices = Invoice::where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return CustomerInvoiceResource::collection($invoices);
    }

    public function show(Request $request, Invoice $invoice)
    {
        if ($invoice->customer_id != $request->user()->id) {
            abort(403);
        }

        return new CustomerInvoiceResource($invoice);
    }
}
