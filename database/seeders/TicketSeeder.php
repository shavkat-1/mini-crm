<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создать 2-3 заявки на каждого клиента
        Customer::all()->each(function ($customer) {
            Ticket::factory(rand(2, 3))->create([
                'customer_id' => $customer->id,
            ])->each(function($ticket) {
                // Добавляем тестовый файл в медиаколлекцию
                $ticket->addMedia(storage_path('app/test-file.pdf'))
                    ->preservingOriginal()
                    ->toMediaCollection('files');
            });
        });
    }
}
