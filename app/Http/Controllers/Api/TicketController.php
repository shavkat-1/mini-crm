<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\TicketStoreRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketStatisticsResource;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {}

    /**
     * Создание заявки через API (из виджета)
     */
    public function store(TicketStoreRequest $request): TicketResource
    {
        $ticket = $this->ticketService->create(
            $request->validated(),
            $request->file('files', [])
        );

        return new TicketResource($ticket);
    }

    /**
     * Статистика заявок (сутки, неделя, месяц)
     * ✅ ИСПРАВЛЕНО: теперь через сервис, а не напрямую к модели!
     */
    public function statistics(): TicketStatisticsResource
    {
        $statistics = $this->ticketService->getStatistics();

        return new TicketStatisticsResource($statistics);
    }
}
