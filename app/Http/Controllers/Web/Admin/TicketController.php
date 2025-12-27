<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\TicketService;
use App\Http\Requests\Tickets\TicketStoreRequest;
use App\Http\Requests\Tickets\TicketUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }


    public function index(): View
{
    $query = $this->ticketService->query();

    if ($status = request('status')) {
        $query->where('status', $status);
    }

    if ($email = request('email')) {
        $query->whereHas('customer', fn($q) => $q->where('email', 'like', "%{$email}%"));
    }

    if ($phone = request('phone')) {
        $query->whereHas('customer', fn($q) => $q->where('phone', 'like', "%{$phone}%"));
    }

    if ($from = request('from')) {
        $query->whereDate('created_at', '>=', $from);
    }

    if ($to = request('to')) {
        $query->whereDate('created_at', '<=', $to);
    }

    $tickets = $query->paginate(20);

    return view('admin.tickets.index', compact('tickets'));
}


    public function show(int $id): View
    {
        $ticket = $this->ticketService->find($id);
        return view('admin.tickets.show', compact('ticket'));
    }


    public function edit(int $id): View
    {
        $ticket = $this->ticketService->find($id);
        return view('admin.tickets.edit', compact('ticket'));
    }


    public function update(TicketUpdateRequest $request, int $id): RedirectResponse
{
    $ticket = $this->ticketService->find($id);

    $data = $request->validated();

    if (!empty($data['manager_answer'])) {
        $data['status'] = 'processed';
        $data['answered_at'] = now();
    }

    $this->ticketService->update($ticket, $data);

    return redirect()
        ->route('admin.tickets.show', $ticket->id)
        ->with('success', 'Ответ отправлен');
}


    public function destroy(int $id): RedirectResponse
    {
        $ticket = $this->ticketService->find($id);
        $this->ticketService->delete($ticket);
        return redirect()->route('tickets.index')
            ->with('success', 'Тикет успешно удален');
    }
}
