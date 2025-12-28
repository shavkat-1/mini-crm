<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *   schema="TicketStoreRequest",
 *   required={"customer_id","subject","message"},
 *   @OA\Property(property="customer_id", type="integer", example=10),
 *   @OA\Property(property="subject", type="string", example="Проблема с заказом"),
 *   @OA\Property(property="message", type="string", example="Не приходит подтверждение"),
 * )
 *
 * @OA\Schema(
 *   schema="TicketResponse",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="status", type="string", example="new"),
 *   @OA\Property(property="created_at", type="string", example="2025-12-27 12:00:00")
 * )
 *
 * @OA\Schema(
 *   schema="TicketStatisticsResponse",
 *   @OA\Property(property="today", type="integer", example=5),
 *   @OA\Property(property="week", type="integer", example=32),
 *   @OA\Property(property="month", type="integer", example=128)
 * )
 */
final class TicketSwagger {}

{
}
