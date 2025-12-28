<?php

namespace App\Swagger\Controllers;

/**
 * @OA\Tag(
 *     name="Tickets",
 *     description="Работа с заявками"
 * )
 */
class TicketController
{
    /**
     * @OA\Post(
     *     path="/api/tickets",
     *     tags={"Tickets"},
     *     summary="Создание заявки",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TicketStoreRequest")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Заявка создана",
     *         @OA\JsonContent(ref="#/components/schemas/TicketResponse")
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function store() {}

    /**
     * @OA\Get(
     *     path="/api/tickets/statistics",
     *     tags={"Tickets"},
     *     summary="Статистика заявок",
     *     description="Статистика заявок за сутки, неделю и месяц",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="today", type="integer", example=5),
     *             @OA\Property(property="week", type="integer", example=32),
     *             @OA\Property(property="month", type="integer", example=128)
     *         )
     *     )
     * )
     */
    public function statistics() {}
}
