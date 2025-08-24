<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    protected $casts = [
        'year' => 'integer',
    ];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }
}
