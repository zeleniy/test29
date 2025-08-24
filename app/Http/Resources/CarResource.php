<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'brand'   => $this->whenLoaded('carModel', fn () => $this->carModel->carBrand->name),
            'model'   => $this->whenLoaded('carModel', fn () => $this->carModel->name),
            'year'    => $this->resource->year,
            'mileage' => $this->resource->mileage,
            'color'   => $this->resource->color,
        ];
    }
}
