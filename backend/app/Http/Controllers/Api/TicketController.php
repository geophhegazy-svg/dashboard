<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;

class TicketController extends Controller
{
    public function index()
    {
        return TicketResource::collection(Ticket::latest()->paginate());
    }
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->validated());
        return new TicketResource($ticket);
    }
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }
    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return new TicketResource($ticket);
    }
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted successfully']);
    }
}
