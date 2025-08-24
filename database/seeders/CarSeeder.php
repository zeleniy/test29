<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = CarModel::all();

        $models->each(function ($model) {
            Car::factory()
                ->count(\rand(0, 3))
                ->for($model)
                ->create();
        });
    }
}
