<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\TicketService;
use App\Http\Requests\Tickets\TicketUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {}

    /**
     * Список заявок с фильтрацией
     */
    public function index(): View
    {
        $tickets = $this->ticketService->getFilteredTickets(
            status: request('status'),
            email: request('email'),
            phone: request('phone'),
            from: request('from'),
            to: request('to')
        );

        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Просмотр заявки
     */
    public function show(int $id): View
    {
        $ticket = $this->ticketService->find($id);

        if (!$ticket) {
            abort(404, 'Заявка не найдена');
        }

        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Форма редактирования заявки
     */
    public function edit(int $id): View
    {
        $ticket = $this->ticketService->find($id);

        if (!$ticket) {
            abort(404, 'Заявка не найдена');
        }

        return view('admin.tickets.edit', compact('ticket'));
    }

    /**
     * Обновление заявки (ответ менеджера)
     */
    public function update(TicketUpdateRequest $request, int $id): RedirectResponse
    {
        $ticket = $this->ticketService->answerTicket($id, $request->validated());

        return redirect()
            ->route('admin.tickets.show', $ticket->id)
            ->with('success', 'Ответ успешно отправлен');
    }

    /**
     * Удаление заявки
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->ticketService->delete($id);

        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Заявка успешно удалена');
    }
}
