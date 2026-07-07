<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketReplyResource;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Services\Ticket\TicketService;


class TicketController extends Controller
{
    public function __construct(
        private readonly TicketService $ticketService
    ) {}

    public function index()
    {
        return TicketResource::collection(
            Ticket::with('customer')
                ->latest()
                ->paginate(20)
        );
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->ticketService->createFromAdmin(
            $request->validated(),
            auth()->id()
        );

        return new TicketResource($ticket);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load([
            'customer',
            'user',
            'replies.customer',
            'replies.user'
        ]);

        return new TicketResource($ticket);
    }

    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $ticket = $this->ticketService->updateFromAdmin(
            $ticket,
            $request->validated(),
            auth()->id()
        );

        return new TicketResource($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $this->ticketService->delete($ticket, auth()->id());

        return response()->json([
            'message' => 'Ticket deleted successfully'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        return response()->json(
            $this->ticketService->adminDashboardStats()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    public function messages(Ticket $ticket)
    {
        $ticket->load([
            'replies.customer',
            'replies.user'
        ]);

        return response()->json([

            'ticket' => [

                'id' => $ticket->id,

                'ticket_number' => $ticket->ticket_number,

                'subject' => $ticket->subject,

                'status' => $ticket->status,

                'priority' => $ticket->priority,

            ],

            'messages' => TicketReplyResource::collection(
                $ticket->replies()->oldest()->get()
            ),

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Reply
    |--------------------------------------------------------------------------
    */

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        try {
            $reply = $this->ticketService->replyAsStaff(
                $ticket,
                auth()->id(),
                $request->message
            );
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }

        return response()->json([

            'message' => 'Reply sent successfully',

            'data' => new TicketReplyResource($reply)

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Change Status
    |--------------------------------------------------------------------------
    */

    public function changeStatus(Request $request, Ticket $ticket)
    {
        $request->validate([

            'status' => 'required|in:open,in_progress,resolved,closed'
        ]);

        $ticket = $this->ticketService->changeStatus(
            $ticket,
            $request->status,
            auth()->id()
        );

        return new TicketResource($ticket);
    }

    /*
    |--------------------------------------------------------------------------
    | Assign Ticket
    |--------------------------------------------------------------------------
    */

    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([

            'user_id' => 'required|exists:users,id'

        ]);

        $user = User::findOrFail($request->user_id);

        $ticket = $this->ticketService->assign(
            $ticket,
            $user,
            auth()->id()
        );

        return response()->json([

            'message' => 'Ticket assigned successfully',

            'data' => new TicketResource($ticket)

        ]);
    }
}
