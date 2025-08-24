<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year'    => $this->faker->boolean ? $this->faker->year : null,
            'mileage' => $this->faker->boolean ? \rand(1, 725_000) : null,
            'color'   => $this->faker->boolean ? $this->faker->colorName : null,
        ];
    }
}
