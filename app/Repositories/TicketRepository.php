<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository
{
    protected Ticket $model;
    public function __construct(Ticket $ticket)
    {
        $this->model = $ticket;
    }


    public function all(): Collection {
        return $this->model->with('customer')->get();
    }

    public function find(int $id): ?Ticket {
        return $this->model->with('customer')->find($id);
    }

    public function query()
    {
        return $this->model->with('customer', 'media');
    }

    public function create(array $data): Ticket {
        return $this->model->create($data);
    }

    public function update(Ticket $ticket, array $data): bool {
        return $ticket->update($data);
    }

    public function delete(Ticket $ticket): bool {
        return $ticket->delete();
    }

   public function ticketsByStatus(string $status, $paginate = false)
{
    $query = $this->model->with('customer')->where('status', $status);
    return $paginate ? $query->paginate(20) : $query->get();
}


}
