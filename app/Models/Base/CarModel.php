<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Car;
use App\Models\CarBrand;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class CarModel
 * 
 * @property int $id
 * @property string $name
 * @property int $brand_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CarBrand $carBrand
 * @property Collection|Car[] $cars
 *
 * @package App\Models\Base
 */
class CarModel extends Model
{
    const ID = 'id';
    const NAME = 'name';
    const BRAND_ID = 'brand_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $table = 'car_models';
    protected $perPage = 10;
    public static $snakeAttributes = false;

    protected $casts = [
        self::ID => 'int',
        self::BRAND_ID => 'int',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime'
    ];

    public function carBrand(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class, \App\Models\CarModel::BRAND_ID);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, Car::MODEL_ID);
    }
}
