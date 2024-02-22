<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence,
            'author' => fake()->name . ' ' . fake()->lastName,
            'year' => fake()->year,
            'publishing' => fake()->company
        ];
    }
}
