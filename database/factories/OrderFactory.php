<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement([0, 1, 2]),
            'user_id' => User::get()->random()->id,
            'confirmed_at' => fake()->dateTimeBetween('-3 day', 'now'),
            'created_at' => fake()->dateTimeBetween('-1 week', 'now'),

        ];
    }
}
