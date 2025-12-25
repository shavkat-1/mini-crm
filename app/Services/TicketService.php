<?php

namespace App\Services;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use App\Repositories\TicketRepository;
use Illuminate\Database\Eloquent\Collection;

class TicketService
{
    protected TicketRepository $repository;

    public function __construct(TicketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function find(int $id): ?Ticket
    {
        return $this->repository->find($id);
    }

    public function create(array $data, array $files = []): Ticket
    {
        $ticket = $this->repository->create($data);

        foreach ($files as $file) {
            $ticket->addMedia($file)->toMediaCollection('files');
        }

        return $ticket;
    }

    public function update(Ticket $ticket, array $data, array $files = []): Ticket
    {
        $this->repository->update($ticket, $data);

        foreach ($files as $file) {
            $ticket->addMedia($file)->toMediaCollection('files');
        }

        return $ticket->fresh();
    }

    public function delete(Ticket $ticket): bool
    {
        return $this->repository->delete($ticket);
    }

    public function ticketsByStatus(TicketStatus $status): Collection
{
    return $this->repository->ticketsByStatus($status->value);
}
}
