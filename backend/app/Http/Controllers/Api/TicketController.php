<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\QueryBus\QueryDispatcher;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketReplyResource;
use App\Modules\Ticket\Application\Queries\GetTicketRepliesQuery;
use App\Modules\Ticket\Application\Queries\GetAdminTicketStatisticsQuery;
use App\Modules\Ticket\Application\Queries\PaginateTicketsQuery;
use App\Modules\Ticket\Application\Queries\FindTicketQuery;
use Illuminate\Http\Request;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Models\User;
use App\Modules\Ticket\Application\Actions\CreateAdminTicketAction;
use App\Modules\Ticket\Application\Actions\UpdateTicketFromAdminAction;
use App\Modules\Ticket\Application\Actions\DeleteTicketAction;
use App\Modules\Ticket\Application\Actions\ReplyAsStaffAction;
use App\Modules\Ticket\Application\Actions\ChangeTicketStatusAction;
use App\Modules\Ticket\Application\Actions\AssignTicketAction;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct(
        private readonly CreateAdminTicketAction $createAdminTicket,
        private readonly UpdateTicketFromAdminAction $updateTicket,
        private readonly DeleteTicketAction $deleteTicket,
        private readonly ReplyAsStaffAction $replyAsStaff,
        private readonly ChangeTicketStatusAction $changeTicketStatus,
        private readonly AssignTicketAction $assignTicket,
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index()
    {
        $tickets = $this->queryDispatcher->dispatch(
            new PaginateTicketsQuery(
                perPage: 20,
            )
        );

        return TicketResource::collection($tickets);
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->createAdminTicket->execute(
            $request->validated(),
            auth::id(),
        );

        return new TicketResource($ticket);
    }

    public function show(Ticket $ticket)
    {
        $ticket = $this->queryDispatcher->dispatch(
            new FindTicketQuery(
                ticketId: (int) $ticket->id,
                relations: [
                    'customer',
                    'user',
                    'replies.customer',
                    'replies.user',
                ],
            )
        );

        abort_if($ticket === null, 404);

        return new TicketResource($ticket);
    }

    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $ticket = $this->updateTicket->execute(
            $ticket,
            $request->validated(),
            auth::id(),
        );

        return new TicketResource($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $this->deleteTicket->execute($ticket, auth::id());

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
            $this->queryDispatcher->dispatch(
                new GetAdminTicketStatisticsQuery()
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    public function messages(Ticket $ticket)
    {
        $messages = $this->queryDispatcher->dispatch(
            new GetTicketRepliesQuery(
                ticketId: (int) $ticket->id,
            )
        );

        return response()->json([

            'ticket' => [

                'id' => $ticket->id,

                'ticket_number' => $ticket->ticket_number,

                'subject' => $ticket->subject,

                'status' => $ticket->status,

                'priority' => $ticket->priority,

            ],

            'messages' => TicketReplyResource::collection(
                $messages
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
            $reply = $this->replyAsStaff->execute(
                $ticket,
                auth::id(),
                $request->message,
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

        $ticket = $this->changeTicketStatus->execute(
            $ticket,
            $request->status,
            auth::id(),
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

        $ticket = $this->assignTicket->execute(
            $ticket,
            $user,
            auth::id(),
        );

        return response()->json([

            'message' => 'Ticket assigned successfully',

            'data' => new TicketResource($ticket)

        ]);
    }
}
