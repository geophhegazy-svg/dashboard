<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Ticket\Application\Queries\PaginateCustomerTicketsQuery;
use App\Modules\Ticket\Application\Queries\FindCustomerTicketQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $tickets = $this->queryDispatcher->dispatch(
            new PaginateCustomerTicketsQuery(
                customerId: (int) $customer->id,
                perPage: 10,
            )
        );

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

        $this->createCustomerTicket->execute(
            $customer,
            [
                'subject'     => $request->subject,
                'description' => $request->message,
                'priority'    => $request->priority,
            ],
        );

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

        $ticket = $this->queryDispatcher->dispatch(
            new FindCustomerTicketQuery(
                customerId: (int) $customer->id,
                ticketId: $id,
            )
        );

        abort_if($ticket === null, 404);

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

        $ticket = $this->queryDispatcher->dispatch(
            new FindCustomerTicketQuery(
                customerId: (int) $customer->id,
                ticketId: $id,
            )
        );

        abort_if($ticket === null, 404);

        $this->replyAsCustomer->execute(
            $ticket,
            $customer,
            $request->message,
        );

        return back()->with(
            'success',
            'تم إضافة الرد بنجاح'
        );
    }

    public function close(
        int $id
    ) {
        $customer = Auth::guard('customer')->user();

        $ticket = $this->queryDispatcher->dispatch(
            new FindCustomerTicketQuery(
                customerId: (int) $customer->id,
                ticketId: $id,
            )
        );

        abort_if($ticket === null, 404);

        $this->closeTicketByCustomer->execute(
            $ticket,
        );

        return back()->with(
            'success',
            'تم إغلاق التذكرة بنجاح'
        );
    }
}
