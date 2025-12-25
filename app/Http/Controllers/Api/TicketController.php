<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\TicketStoreRequest;
use App\Http\Resources\TicketResource;
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
        $today = \App\Models\Ticket::lastDay()->count();
        $week = \App\Models\Ticket::lastWeek()->count();
        $month = \App\Models\Ticket::where('created_at', '>=', Carbon::now()->subMonth())->count();

        return response()->json([
            'today' => $today,
            'week' => $week,
            'month' => $month,
        ]);
    }
}
