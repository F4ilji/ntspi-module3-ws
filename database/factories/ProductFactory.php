<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Product #'.fake()->randomNumber(5, false),
            'description' => fake()->paragraph(),
            'price' => fake()->randomNumber(5, false),
            'image' => 'images/image.jpeg',
            'category_id' => Category::get()->random()->id,
        ];
    }
}
