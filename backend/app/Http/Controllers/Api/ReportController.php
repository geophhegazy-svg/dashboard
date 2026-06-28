<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function dashboard()
    {
        return response()->json(['customers' => Customer::count(), 'invoices' => Invoice::count(), 'paid_invoices' => Invoice::where('status', 'paid')->count(), 'pending_invoices' => Invoice::where('status', 'pending')->count(), 'payments' => Payment::count(), 'tickets_open' => Ticket::where('status', 'open')->count(), 'revenue' => Payment::sum('amount'),]);
    }
    public function revenue()
    {
        return response()->json(['total_revenue' => Payment::sum('amount'), 'payments' => Payment::latest()->get(),]);
    }
    public function invoices()
    {
        return response()->json(['paid' => Invoice::where('status', 'paid')->count(), 'pending' => Invoice::where('status', 'pending')->count(), 'overdue' => Invoice::where('status', 'overdue')->count(), 'cancelled' => Invoice::where('status', 'cancelled')->count(),]);
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
