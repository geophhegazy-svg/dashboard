<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketReplyResource;
use App\Services\ActivityLogService;

class CustomerTicketController extends Controller
{
    public function index(Request $request)
    {
        return TicketResource::collection(

            Ticket::where('customer_id', $request->user()->id)
                ->latest()
                ->paginate(10)

        );
    }

    public function dashboard(Request $request)
    {
        $customer = $request->user();

        $tickets = Ticket::where('customer_id', $customer->id);

        $lastTicket = (clone $tickets)->latest()->first();

        return response()->json([

            'statistics' => [

                'total' => (clone $tickets)->count(),

                'open' => (clone $tickets)
                    ->where('status', 'open')
                    ->count(),

                'closed' => (clone $tickets)
                    ->where('status', 'closed')
                    ->count(),

                'high_priority' => (clone $tickets)
                    ->where('priority', 'high')
                    ->count(),

            ],

            'last_ticket' => $lastTicket
                ? new TicketResource($lastTicket)
                : null,

        ]);
    }

    public function show(Request $request, Ticket $ticket)
    {
        abort_if(
            $ticket->customer_id != $request->user()->id,
            403
        );

        $ticket->load(
            'replies.customer',
            'replies.user'
        );

        return new TicketResource($ticket);
    }

    public function messages(Request $request, Ticket $ticket)
    {
        abort_if(
            $ticket->customer_id != $request->user()->id,
            403
        );

        $messages = TicketReply::with([
            'customer:id,name',
            'user:id,name'
        ])
            ->where('ticket_id', $ticket->id)
            ->orderBy('created_at')
            ->get();

        return response()->json([

            'ticket' => [

                'id' => $ticket->id,

                'ticket_number' => $ticket->ticket_number,

                'subject' => $ticket->subject,

                'status' => $ticket->status,

                'priority' => $ticket->priority,

            ],

            'messages' => TicketReplyResource::collection($messages)

        ]);
    }
    public function store(Request $request)
    {
        $request->validate([

            'subject'     => 'required|string|max:255',

            'description' => 'required|string',

            'priority'    => 'nullable|in:low,medium,high',

        ]);

        $customer = $request->user();

        $ticket = Ticket::create([

            'tenant_id'     => $customer->tenant_id,

            'customer_id'   => $customer->id,

            'user_id'       => null,

            'ticket_number' =>
            'TKT-' .
                now()->format('YmdHis') .
                '-' .
                $customer->id,

            'subject'       => $request->subject,

            'description'   => $request->description,

            'priority'      => $request->priority ?? 'medium',

            'status'        => 'open',

            'opened_at'     => now(),

            'closed_at'     => null,

            'notes'         => null,

        ]);

        ActivityLogService::log(

            tenantId: $customer->tenant_id,

            userId: null,

            module: 'ticket',

            action: 'created',

            description: "Customer {$customer->name} created ticket {$ticket->ticket_number}"

        );

        return response()->json([

            'message' => 'Ticket created successfully',

            'data' => new TicketResource($ticket)

        ], 201);
    }

    public function reply(Request $request, Ticket $ticket)
    {
        abort_if(
            $ticket->customer_id != $request->user()->id,
            403
        );

        if ($ticket->status === 'closed') {

            return response()->json([
                'message' => 'Cannot reply to closed ticket.'
            ], 422);
        }

        $request->validate([

            'message' => 'required|string'

        ]);

        Log::info('Incoming message', [
            'message' => $request->message,
            'hex' => bin2hex($request->message),
        ]);

        $reply = TicketReply::create([

            'ticket_id'   => $ticket->id,

            'customer_id' => $request->user()->id,

            'user_id'     => null,

            'message'     => $request->message,

            'is_staff'    => false,

            'sent_at'     => now(),

        ]);

        ActivityLogService::log(

            tenantId: $ticket->tenant_id,

            userId: null,

            module: 'ticket',

            action: 'reply',

            description: "Customer replied to ticket {$ticket->ticket_number}"

        );

        return response()->json([

            'message' => 'Reply added successfully',

            'data' => new TicketReplyResource($reply)

        ]);
    }

    public function close(Request $request, Ticket $ticket)
    {
        abort_if(
            $ticket->customer_id != $request->user()->id,
            403
        );

        if ($ticket->status === 'closed') {

            return response()->json([

                'message' => 'Ticket already closed.'

            ], 422);
        }

        $ticket->update([

            'status' => 'closed',

            'closed_at' => now()

        ]);

        ActivityLogService::log(

            tenantId: $ticket->tenant_id,

            userId: null,

            module: 'ticket',

            action: 'closed',

            description: "Customer closed ticket {$ticket->ticket_number}"

        );

        return response()->json([

            'message' => 'Ticket closed successfully',

            'data' => new TicketResource($ticket->fresh())

        ]);
    }
}
