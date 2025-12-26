<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id' => $this->id,

            // Клиент (безопасно)
            'customer' => $this->customer ? [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
            ] : null,

            // Данные заявки
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status->value, // enum
            'answered_at' => $this->answered_at?->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),

            // Файлы (spatie media)
            'files' => $this->getMedia('files')->map(fn ($media) => [
                'id' => $media->id,
                'name' => $media->name,
                'url' => $media->getUrl(),
            ]),
        ];
    }

}
