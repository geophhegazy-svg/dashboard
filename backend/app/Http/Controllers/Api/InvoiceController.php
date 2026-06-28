<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\InvoiceResource;

class InvoiceController extends Controller
{
    public function index()
    {
        return InvoiceResource::collection(Invoice::with(['customer', 'subscription'])->latest()->paginate());
    }
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->validated());
        return new InvoiceResource($invoice->load(['customer', 'subscription']));
    }
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice->load(['customer', 'subscription']));
    }
    public function update(StoreInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());
        return new InvoiceResource($invoice->load(['customer', 'subscription']));
    }
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}
