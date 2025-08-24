<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CarModelControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test models listing.
     * @return void
     */
    public function testIndex(): void
    {
        CarModel::factory()->count(15)->for(CarBrand::factory()->create())->create();
        $response = $this->get('/models');

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
                    $json->whereType('name', 'string')
                        ->whereType('brand', 'string')
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
                    $json->whereType('name', 'string')
                        ->whereType('brand', 'string')
                )
        );
    }
}
