<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\CreateRequest;
use App\Http\Requests\Ticket\EditRequest;
use App\Http\Requests\Ticket\MessageRequest;
use App\Http\Services\Ticket\TicketService;
use App\Models\Ticket\Status;
use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
        $this->middleware('can:manage-tickets');
    }

    public function index(Request $request)
    {
        $query = Ticket::orderByDesc('updated_at');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('user'))) {
            $query->where('user_id', $value);
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        $tickets = $query->paginate(20);
        $statuses = Status::statusesList();

        return view('admin.tickets.index', compact('tickets', 'statuses'));
    }

    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function editForm(Ticket $ticket)
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

   public function edit(EditRequest $request, Ticket $ticket)
   {
       try {
           $this->ticketService->edit($ticket->id, $request);
       } catch (\DomainException $exception) {
           return back()->with('error', $exception->getMessage());
       }
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

    public function approve(Ticket $ticket)
    {
        try {
            $this->ticketService->approve(\Auth::id(), $ticket->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.tickets.show', $ticket);
    }

    public function close(Ticket $ticket)
    {
        try {
            $this->ticketService->close(\Auth::id(), $ticket->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.tickets.show', $ticket);
    }

    public function reopen(Ticket $ticket)
    {
        try {
            $this->ticketService->reopen(\Auth::id(), $ticket->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.tickets.show', $ticket);
    }

    public function destroy(Ticket $ticket)
    {
        try {
            $this->ticketService->removeByAdmin($ticket->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.tickets.index');
    }


}
