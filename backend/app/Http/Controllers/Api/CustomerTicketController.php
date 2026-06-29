<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class CustomerTicketController extends Controller
{
    public function index(Request $request)
    {
        return Ticket::where('customer_id', $request->user()->id)
            ->latest()
            ->paginate(10);
    }

    public function show(Request $request, Ticket $ticket)
    {
        abort_if(
            $ticket->customer_id != $request->user()->id,
            403
        );

        return $ticket;
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'nullable|in:low,medium,high'
        ]);

        $ticket = Ticket::create([

            'tenant_id' => $request->user()->tenant_id,

            'customer_id' => $request->user()->id,

            'subject' => $request->subject,

            'description' => $request->description,

            'priority' => $request->priority ?? 'medium',

            'status' => 'open'

        ]);

        return response()->json([
            'message' => 'Ticket created successfully',
            'data' => $ticket
        ], 201);
    }

    public function close(Request $request, Ticket $ticket)
    {
        abort_if(
            $ticket->customer_id != $request->user()->id,
            403
        );

        $ticket->update([
            'status' => 'closed'
        ]);

        return response()->json([
            'message' => 'Ticket closed successfully'
        ]);
    }
}
