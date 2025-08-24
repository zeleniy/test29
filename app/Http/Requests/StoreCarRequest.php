<?php

namespace App\Http\Requests;

use App\Models\Car;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model_id' => 'required|integer|exists:car_models,id',
            'year'     => 'nullable|integer|min:' . Car::YEAR_MIN . '|max:' . now()->year,
            'mileage'  => 'nullable|integer|min:' . Car::MILEAGE_MIN . '|max:' . Car::MILEAGE_MAX,
            'color'    => 'nullable|string|max:' . Car::COLOR_MAX_LENGTH,
        ];
    }
}
