<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends \App\Models\Base\Car
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    const int YEAR_MIN = 1886;
    const int MILEAGE_MIN = 0;
    const int MILEAGE_MAX = 16_777_215;
    const int COLOR_MAX_LENGTH = 32;
}
