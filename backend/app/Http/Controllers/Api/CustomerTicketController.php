<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Ticket\Application\Queries\PaginateCustomerTicketsQuery;
use App\Modules\Ticket\Application\Queries\FindCustomerTicketQuery;
use App\Modules\Ticket\Application\Queries\GetTicketRepliesQuery;
use App\Modules\Ticket\Application\Queries\GetCustomerTicketStatisticsQuery;
use Illuminate\Http\Request;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketReplyResource;
use App\Modules\Ticket\Application\Actions\CreateCustomerTicketAction;
use App\Modules\Ticket\Application\Actions\ReplyAsCustomerAction;
use App\Modules\Ticket\Application\Actions\CloseTicketByCustomerAction;

class CustomerTicketController extends Controller
{
    public function __construct(
        private readonly CreateCustomerTicketAction $createCustomerTicket,
        private readonly ReplyAsCustomerAction $replyAsCustomer,
        private readonly CloseTicketByCustomerAction $closeTicketByCustomer,
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index(Request $request)
    {
        return TicketResource::collection(
            $this->queryDispatcher->dispatch(
                new PaginateCustomerTicketsQuery(
                    customerId: (int) $request->user()->id,
                    perPage: 10,
                )
            )
        );
    }

    public function dashboard(Request $request)
    {
        return response()->json(
            $this->queryDispatcher->dispatch(
                new GetCustomerTicketStatisticsQuery(
                    customerId: (int) $request->user()->id,
                )
            )
        );
    }

    public function show(Request $request, Ticket $ticket)
    {
        $ticket = $this->queryDispatcher->dispatch(
            new FindCustomerTicketQuery(
                customerId: (int) $request->user()->id,
                ticketId: (int) $ticket->id,
                relations: [
                    'replies.customer',
                    'replies.user',
                ],
            )
        );

        abort_if($ticket === null, 404);

        return new TicketResource($ticket);
    }

    public function messages(Request $request, Ticket $ticket)
    {
        $ticket = $this->queryDispatcher->dispatch(
            new FindCustomerTicketQuery(
                customerId: (int) $request->user()->id,
                ticketId: (int) $ticket->id,
            )
        );

        abort_if($ticket === null, 404);

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

        $ticket = $this->createCustomerTicket->execute(
            $request->user(),
            $request->only(['subject', 'description', 'priority']),
        );

        return response()->json([

            'message' => 'Ticket created successfully',

            'data' => new TicketResource($ticket)

        ], 201);
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $ticket = $this->queryDispatcher->dispatch(
            new FindCustomerTicketQuery(
                customerId: (int) $request->user()->id,
                ticketId: (int) $ticket->id,
            )
        );

        abort_if($ticket === null, 404);

        $request->validate([

            'message' => 'required|string'

        ]);

        try {
            $reply = $this->replyAsCustomer->execute(
                $ticket,
                $request->user(),
                $request->message,
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
        $ticket = $this->queryDispatcher->dispatch(
            new FindCustomerTicketQuery(
                customerId: (int) $request->user()->id,
                ticketId: (int) $ticket->id,
            )
        );

        abort_if($ticket === null, 404);

        try {
            $ticket = $this->closeTicketByCustomer->execute($ticket);
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
