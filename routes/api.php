<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;

// Создание заявки через AJAX (виджет)
Route::post('/tickets', [TicketController::class, 'store']);

// Статистика заявок (сутки, неделя, месяц)
Route::get('/tickets/statistics', [TicketController::class, 'statistics']);
