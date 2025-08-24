<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends \App\Models\Base\Car
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;
}
