<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\CreateRequest;
use App\Http\Requests\Ticket\MessageRequest;
use App\Http\Services\Ticket\TicketService;
use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        $tickets = Ticket::forUser(\Auth::user())->orderByDesc('updated_at')->paginate(20);

        return view('cabinet.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('cabinet.tickets.show', compact('ticket'));
    }

    public function create()
    {
        return view('cabinet.tickets.create');
    }

    public function store(CreateRequest $request)
    {
        try {
            $ticket = $this->ticketService->create(\Auth::id(), $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.tickets.show', $ticket);
    }

    public function message(MessageRequest $request, Ticket $ticket)
    {
        try {
            $this->ticketService->message(\Auth::id(), $ticket->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.tickets.show', $ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $this->checkAccess($ticket);

        try {
            $this->ticketService->removeByOwner($ticket->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.tickets.index');
    }

    private function checkAccess(Ticket $ticket): void
    {
        if (!\Gate::allows('manage-own-ticket', $ticket)) {
            abort(403);
        }
    }
}
