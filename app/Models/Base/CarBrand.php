<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\CarModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class CarBrand
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|CarModel[] $carModels
 *
 * @package App\Models\Base
 */
class CarBrand extends Model
{
    const ID = 'id';
    const NAME = 'name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $table = 'car_brands';
    protected $perPage = 10;
    public static $snakeAttributes = false;

    protected $casts = [
        self::ID => 'int',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime'
    ];

    protected $fillable = [
        self::NAME
    ];

    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class, CarModel::BRAND_ID);
    }
}
