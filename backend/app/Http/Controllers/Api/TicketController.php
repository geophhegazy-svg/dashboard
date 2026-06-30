<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketReplyResource;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Services\ActivityLogService;


class TicketController extends Controller
{
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
        $ticket = Ticket::create($request->validated());

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: auth()->id(),
            module: 'ticket',
            action: 'created',
            description: "Created ticket {$ticket->ticket_number}"
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
        $ticket->update($request->validated());

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: auth()->id(),
            module: 'ticket',
            action: 'updated',
            description: "Updated ticket {$ticket->ticket_number}"
        );

        return new TicketResource($ticket->fresh());
    }

    public function destroy(Ticket $ticket)
    {
        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: auth()->id(),
            module: 'ticket',
            action: 'deleted',
            description: "Deleted ticket {$ticket->ticket_number}"
        );

        $ticket->delete();

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
        return response()->json([

            'total' => Ticket::count(),

            'open' => Ticket::where('status', 'open')->count(),

            'closed' => Ticket::where('status', 'closed')->count(),

            'high_priority' => Ticket::where('priority', 'high')->count(),

            'today' => Ticket::whereDate('created_at', today())->count(),

        ]);
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

        if ($ticket->status == 'closed') {

            return response()->json([
                'message' => 'Ticket is already closed.'
            ], 422);
        }

        $reply = TicketReply::create([

            'ticket_id' => $ticket->id,

            'customer_id' => null,

            'user_id' => auth()->id(),

            'message' => $request->message,

            'is_staff' => true,

            'sent_at' => now(),

        ]);

        ActivityLogService::log(

            tenantId: $ticket->tenant_id,

            userId: auth()->id(),

            module: 'ticket',

            action: 'reply',

            description: "Staff replied to {$ticket->ticket_number}"

        );

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

        $ticket->status = $request->status;

        if ($request->status == 'closed') {

            $ticket->closed_at = now();
        }

        $ticket->save();

        ActivityLogService::log(

            tenantId: $ticket->tenant_id,

            userId: auth()->id(),

            module: 'ticket',

            action: 'status',

            description: "Changed {$ticket->ticket_number} status to {$ticket->status}"

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

        $ticket->update([

            'user_id' => $user->id

        ]);

        ActivityLogService::log(

            tenantId: $ticket->tenant_id,

            userId: auth()->id(),

            module: 'ticket',

            action: 'assigned',

            description: "Assigned {$ticket->ticket_number} to {$user->name}"

        );

        return response()->json([

            'message' => 'Ticket assigned successfully',

            'data' => new TicketResource($ticket->fresh())

        ]);
    }
}
