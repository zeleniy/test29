<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $brands = CarBrand::all();

        $brands->each(function ($brand) {
            CarModel::factory()
                ->count(\rand(0, 3))
                ->for($brand)
                ->create();
        });
    }
}
