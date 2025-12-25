<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\TicketStatus;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([
                TicketStatus::NEW,
                TicketStatus::IN_PROGRESS,
                TicketStatus::PROCESSED,
            ]),
            'answered_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
