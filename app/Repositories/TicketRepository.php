<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketRepository
{
    public function __construct(
        private Ticket $model
    ) {}

    public function all(): Collection
    {
        return $this->model
            ->with('customer')
            ->get();
    }

    public function find(int $id): ?Ticket
    {
        return $this->model
            ->with(['customer', 'media'])
            ->find($id);
    }

    public function getFiltered(
        ?string $status = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $from = null,
        ?string $to = null
    ): LengthAwarePaginator {
        $query = $this->model->with(['customer', 'media']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($email) {
            $query->whereHas('customer', fn($q) =>
                $q->where('email', 'like', "%{$email}%")
            );
        }

        if ($phone) {
            $query->whereHas('customer', fn($q) =>
                $q->where('phone', 'like', "%{$phone}%")
            );
        }

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        return $query
            ->latest()
            ->paginate(20);
    }

    public function create(array $data): Ticket
    {
        return $this->model->create($data);
    }

    public function update(Ticket $ticket, array $data): bool
    {
        return $ticket->update($data);
    }

    public function delete(Ticket $ticket): bool
    {
        return $ticket->delete();
    }

    public function existsTodayByCustomer(int $customerId): bool
    {
        return $this->model
            ->where('customer_id', $customerId)
            ->whereDate('created_at', today())
            ->exists();
    }

    public function ticketsByStatus(string $status, bool $paginate = false)
    {
        $query = $this->model
            ->with('customer')
            ->status($status); // используем scope!

        return $paginate ? $query->paginate(20) : $query->get();
    }

    /**
     * Подсчет заявок за сегодня (используем scope!)
     */
    public function countToday(): int
    {
        return $this->model->today()->count();
    }

    /**
     * Подсчет заявок за текущую неделю (используем scope!)
     */
    public function countThisWeek(): int
    {
        return $this->model->thisWeek()->count();
    }

    /**
     * Подсчет заявок за текущий месяц (используем scope!)
     */
    public function countThisMonth(): int
    {
        return $this->model->thisMonth()->count();
    }
}
