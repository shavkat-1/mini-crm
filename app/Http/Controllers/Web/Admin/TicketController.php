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
        $tickets = $this->ticketService->all();
        return view('tickets.index', compact('tickets'));
    }


    public function create(): View
    {
        return view('tickets.create');
    }

        public function store(TicketStoreRequest $request): RedirectResponse
    {
        $this->ticketService->create($request->validated());
        return redirect()->route('tickets.index')
            ->with('success', 'Тикет успешно создан');
    }


    public function show(int $id): View
    {
        $ticket = $this->ticketService->find($id);
        return view('tickets.show', compact('ticket'));
    }


    public function edit(int $id): View
    {
        $ticket = $this->ticketService->find($id);
        return view('tickets.edit', compact('ticket'));
    }


    public function update(TicketUpdateRequest $request, int $id): RedirectResponse
    {
        $ticket = $this->ticketService->find($id);
        $this->ticketService->update($ticket, $request->validated());
        return redirect()->route('tickets.index')
            ->with('success', 'Тикет успешно обновлен');
    }


    public function destroy(int $id): RedirectResponse
    {
        $ticket = $this->ticketService->find($id);
        $this->ticketService->delete($ticket);
        return redirect()->route('tickets.index')
            ->with('success', 'Тикет успешно удален');
    }
}
