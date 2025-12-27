<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Отключаем проверку внешних ключей
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Очищаем таблицы
        User::truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();

        // Включаем проверку обратно
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Создать админа с использованием метода фабрики
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Создать менеджеров с использованием метода фабрики
        User::factory(2)->manager()->create();

        // Опционально: создать обычных пользователей
        User::factory(5)->user()->create();

    }
}
