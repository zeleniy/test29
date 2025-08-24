<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testIndex(): void
    {
        Car::factory()->count(15)->for(CarModel::factory()->create([
            'brand_id' => CarBrand::factory()->create()
        ]))->create();

        $response = $this->get('/api/cars');

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) =>
            $json->has('meta', fn(AssertableJson $json) =>
                $json->whereType('path', 'string')
                    ->where('per_page', 10)
                    ->whereNull('prev_cursor')
                    ->whereType('next_cursor', 'string')
                )->has('links', fn(AssertableJson $json) =>
                    $json->whereNull('first')
                        ->whereNull('last')
                        ->whereNull('prev')
                        ->whereType('next', 'string')
                )->has('data', 10, fn(AssertableJson $json) =>
                    $json->whereType('brand', 'string')
                        ->whereType('model', 'string')
                        ->whereType('year', ['integer', 'null'])
                        ->whereType('mileage', ['integer', 'null'])
                        ->whereType('color', ['string', 'null'])
                )
        );

        $nextPageLink = $response->json('links.next');
        $response = $this->get($nextPageLink);

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) =>
        $json->has('meta', fn(AssertableJson $json) =>
            $json->whereType('path', 'string')
                ->where('per_page', 10)
                ->whereType('prev_cursor', 'string')
                ->whereNull('next_cursor')
            )->has('links', fn(AssertableJson $json) =>
                $json->whereNull('first')
                    ->whereNull('last')
                    ->whereType('prev', 'string')
                    ->whereNull('next')
            )->has('data', 5, fn(AssertableJson $json) =>
                $json->whereType('brand', 'string')
                    ->whereType('model', 'string')
                    ->whereType('year', ['integer', 'null'])
                    ->whereType('mileage', ['integer', 'null'])
                    ->whereType('color', ['string', 'null'])
            )
        );
    }

    /**
     * @return void
     */
    public function testShow(): void
    {
        $brand = CarBrand::factory()->create();
        $model = CarModel::factory()->create(['brand_id' => $brand->id]);
        $car   = Car::factory()->for($model)->create();

        $response = $this->get('/api/cars/' . $car->id);

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) =>
            $json->has('data', fn(AssertableJson $json) =>
                $json->where('brand', $brand->name)
                    ->where('model', $model->name)
                    ->where('year', $car->year)
                    ->where('mileage', $car->mileage)
                    ->where('color', $car->color)
            )
        );
    }

    /**
     * @return void
     */
    public function testDestroy(): void
    {
        $car = Car::factory()->for(CarModel::factory()->create([
            'brand_id' => CarBrand::factory()->create()
        ]))->create();

        $response = $this->delete('/api/cars/' . $car->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing($car);
    }

    /**
     * @return void
     */
    public function testStoreWithValidData(): void
    {
        $brand = CarBrand::factory()->create();
        $model = CarModel::factory()->create(['brand_id' => $brand->id]);
        $car   = Car::factory()->make();

        $response = $this->postJson('/api/cars/', [
            'model_id' => $model->id,
            'year'     => $car->year,
            'mileage'  => $car->mileage,
            'color'    => $car->color,
        ]);

        $response->assertStatus(201);

        $response->assertJson(fn(AssertableJson $json) =>
            $json->has('data', fn(AssertableJson $json) =>
                $json->where('brand', $brand->name)
                    ->where('model', $model->name)
                    ->where('year', $car->year)
                    ->where('mileage', $car->mileage)
                    ->where('color', $car->color)
            )
        );

        $this->assertDatabaseHas($response->json('data.id'));
    }

    /**
     * @return void
     */
    public function testStoreWithInvalidData(): void
    {
        $model = CarModel::factory()->create([
            'brand_id' => CarBrand::factory()->create()
        ]);

        $carsInDb = Car::count();

        $response = $this->postJson('/api/cars/', [
            'model_id' => $model->id,
            'year'     => now()->year + 1,
            'mileage'  => Car::MILEAGE_MAX + 1,
            'color'    => 21,
        ]);

        $response->assertStatus(422);

        $response->assertJson(fn(AssertableJson $json) =>
            $json->whereType('message', 'string')
                ->has('errors', fn(AssertableJson $errors) =>
                    $errors->has('year', 1)
                        ->whereType('year.0', 'string')
                        ->has('mileage', 1)
                        ->whereType('mileage.0', 'string')
                        ->has('color', 1)
                        ->whereType('color.0', 'string')
                )
        );

        $this->assertEquals($carsInDb, Car::count());
    }
}
