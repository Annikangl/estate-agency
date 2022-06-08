<?php


namespace App\Http\Services\Ticket;


use App\Http\Requests\Ticket\CreateRequest;
use App\Http\Requests\Ticket\EditRequest;
use App\Http\Requests\Ticket\MessageRequest;
use App\Models\Ticket\Ticket;

class TicketService
{

    public function create(int $userId, CreateRequest $request): Ticket
    {
        return Ticket::new($userId,$request['subject'], $request['content']);
    }

    public function edit(int $id, EditRequest $request)
    {
        $ticket = $this->getTicket($id);
        $ticket->edit(
            $request['subject'],
            $request['content']
        );
    }

    public function message(int $userId, int $id, MessageRequest $request): void
    {
        $ticket = $this->getTicket($id);
        $ticket->addMessage($userId, $request['message']);
    }

    public function removeByOwner(int $id): void
    {
        $ticket = $this->getTicket($id);
        if (!$ticket->canBeRemoved()) {
            throw new \DomainException('Нельзя удалить активный тикет');
        }
        $ticket->delete();
    }

    public function removeByAdmin(int $id)
    {
        $ticket = $this->getTicket($id);
        $ticket->delete();
    }

    public function approve(int $userId, int $id): void
    {
        $ticket = $this->getTicket($id);
        $ticket->approve($userId);
    }

    public function close(int $userId, int $id): void
    {
        $ticket = $this->getTicket($id);
        $ticket->close($userId);
    }

    public function reopen(int $userId, int $id): void
    {
        $ticket = $this->getTicket($id);
        $ticket->reopen($userId);
    }

    private function getTicket($id)
    {
        return Ticket::findOrFail($id);
    }
}
