<?php

namespace Database\Factories;

use App\Models\Car;
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
            'year'    => $this->faker->boolean ? \rand(Car::YEAR_MIN, now()->year) : null,
            'mileage' => $this->faker->boolean ? \rand(Car::MILEAGE_MIN, Car::MILEAGE_MAX) : null,
            'color'   => $this->faker->boolean ? $this->faker->colorName : null,
        ];
    }
}
