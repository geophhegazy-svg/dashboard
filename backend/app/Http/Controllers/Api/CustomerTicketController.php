<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketReplyResource;
use App\Services\Ticket\TicketService;

class CustomerTicketController extends Controller
{
    public function __construct(
        private readonly TicketService $ticketService
    ) {}

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
        return response()->json(
            $this->ticketService->customerDashboardStats($request->user())
        );
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

        $ticket = $this->ticketService->createFromCustomer(
            $request->user(),
            $request->only(['subject', 'description', 'priority'])
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

        $request->validate([

            'message' => 'required|string'

        ]);

        try {
            $reply = $this->ticketService->replyAsCustomer(
                $ticket,
                $request->user(),
                $request->message
            );
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }

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

        try {
            $ticket = $this->ticketService->closeByCustomer($ticket);
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }

        return response()->json([

            'message' => 'Ticket closed successfully',

            'data' => new TicketResource($ticket)

        ]);
    }
}
