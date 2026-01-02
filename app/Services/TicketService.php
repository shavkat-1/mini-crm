<?php

namespace App\Services;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use App\Repositories\TicketRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class TicketService
{
    public function __construct(
        private TicketRepository $repository
    ) {}

    /**
     * Получить отфильтрованные заявки с пагинацией
     */
    public function getFilteredTickets(
        ?string $status = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $from = null,
        ?string $to = null
    ): LengthAwarePaginator {
        return $this->repository->getFiltered(
            status: $status,
            email: $email,
            phone: $phone,
            from: $from,
            to: $to
        );
    }

    /**
     * Получить все заявки
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Найти заявку по ID
     */
    public function find(int $id): ?Ticket
    {
        return $this->repository->find($id);
    }

    /**
     * Создать новую заявку с проверкой лимита (одна в сутки)
     */
    public function create(array $data, array $files = []): Ticket
    {
        // Бизнес-правило: не более одной заявки в сутки от одного клиента
        if ($this->repository->existsTodayByCustomer($data['customer_id'])) {
            throw ValidationException::withMessages([
                'customer_id' => ['От одного клиента можно создать только одну заявку в сутки.']
            ]);
        }

        $ticket = $this->repository->create($data);

        // Прикрепление файлов
        if (!empty($files)) {
            foreach ($files as $file) {
                $ticket->addMedia($file)->toMediaCollection('files');
            }
        }

        return $ticket->fresh(['customer', 'media']);
    }

    /**
     * Обновить заявку
     */
    public function update(Ticket $ticket, array $data, array $files = []): Ticket
    {
        $this->repository->update($ticket, $data);

        // Прикрепление новых файлов
        if (!empty($files)) {
            foreach ($files as $file) {
                $ticket->addMedia($file)->toMediaCollection('files');
            }
        }

        return $ticket->fresh(['customer', 'media']);
    }

    /**
     * Ответить на заявку (бизнес-логика)
     */
    public function answerTicket(int $id, array $data): Ticket
    {
        $ticket = $this->find($id);

        if (!$ticket) {
            throw ValidationException::withMessages([
                'id' => ['Заявка не найдена.']
            ]);
        }

        // Бизнес-правило: если менеджер ответил, статус меняется автоматически
        if (!empty($data['manager_answer'])) {
            $data['status'] = TicketStatus::PROCESSED->value;
            $data['answered_at'] = now();
        }

        $this->repository->update($ticket, $data);

        return $ticket->fresh(['customer', 'media']);
    }

    /**
     * Удалить заявку
     */
    public function delete(int $id): bool
    {
        $ticket = $this->find($id);

        if (!$ticket) {
            throw ValidationException::withMessages([
                'id' => ['Заявка не найдена.']
            ]);
        }

        return $this->repository->delete($ticket);
    }

    /**
     * Получить заявки по статусу
     */
    public function ticketsByStatus(TicketStatus $status, bool $paginate = false)
    {
        return $this->repository->ticketsByStatus($status->value, $paginate);
    }

    /**
     * Получить статистику заявок (для API)
     */
    public function getStatistics(): array
    {
        return [
            'today' => $this->repository->countToday(),
            'week'  => $this->repository->countThisWeek(),
            'month' => $this->repository->countThisMonth(),
        ];
    }
}
