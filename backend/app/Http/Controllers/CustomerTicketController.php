<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerTicketController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $tickets = Ticket::query()
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view(
            'customer.tickets',
            compact('tickets')
        );
    }

    public function create()
    {
        return view('customer.ticket-create');
    }

    public function store(
        Request $request
    ) {
        $request->validate([
            'subject'  => 'required|string|max:255',
            'message'  => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $customer = Auth::guard('customer')->user();

        Ticket::create([
            'customer_id' => $customer->id,
            'subject'     => $request->subject,
            'message'     => $request->message,
            'priority'    => $request->priority,
            'status'      => 'open',
            'created_by'  => 'customer',
        ]);

        return redirect()
            ->route('customer.tickets')
            ->with(
                'success',
                'تم إنشاء التذكرة بنجاح'
            );
    }

    public function show(
        int $id
    ) {
        $customer = Auth::guard('customer')->user();

        $ticket = Ticket::query()
            ->where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        return view(
            'customer.ticket-detail',
            compact('ticket')
        );
    }

    public function reply(
        Request $request,
        int $id
    ) {
        $request->validate([
            'message' => 'required|string',
        ]);

        $customer = Auth::guard('customer')->user();

        $ticket = Ticket::query()
            ->where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        TicketReply::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => null,
            'customer_id' => $customer->id,
            'message'     => $request->message,
            'is_customer' => true,
        ]);

        $ticket->update([
            'status' => 'in_progress',
        ]);

        return back()->with(
            'success',
            'تم إضافة الرد بنجاح'
        );
    }

    public function close(
        int $id
    ) {
        $customer = Auth::guard('customer')->user();

        $ticket = Ticket::query()
            ->where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        $ticket->update([
            'status' => 'closed',
        ]);

        return back()->with(
            'success',
            'تم إغلاق التذكرة بنجاح'
        );
    }
}
