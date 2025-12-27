<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 *
 * @method $this admin()
 * @method $this manager()
 * @method $this user()
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Создать пользователя с ролью админа
     */
    public function admin(): static
    {
        return $this->afterCreating(function ($user) {
            $user->assignRole('admin');
        });
    }

    /**
     * Создать пользователя с ролью менеджера
     */
    public function manager(): static
    {
        return $this->afterCreating(function ($user) {
            $user->assignRole('manager');
        });
    }

    /**
     * Создать пользователя с ролью пользователя
     */
    public function user(): static
    {
        return $this->afterCreating(function ($user) {
            $user->assignRole('user');
        });
    }
}
