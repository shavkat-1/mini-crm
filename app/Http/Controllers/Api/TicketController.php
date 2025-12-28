<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\TicketStoreRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketStatisticsResource;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function store(TicketStoreRequest $request)
    {
        $ticket = $this->ticketService->create(
            $request->validated(),
            $request->file('files', [])
        );

        return new TicketResource($ticket);
    }

    public function statistics()
    {
        return new TicketStatisticsResource([
            'today' => Ticket::today()->count(),
            'week'  => Ticket::thisWeek()->count(),
            'month' => Ticket::thisMonth()->count(),
        ]);
    }
}
