<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\CarModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Car
 * 
 * @property int $id
 * @property int $model_id
 * @property integer|null $year
 * @property int|null $mileage
 * @property string|null $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CarModel $carModel
 *
 * @package App\Models\Base
 */
class Car extends Model
{
    const ID = 'id';
    const MODEL_ID = 'model_id';
    const YEAR = 'year';
    const MILEAGE = 'mileage';
    const COLOR = 'color';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $table = 'cars';
    protected $perPage = 10;
    public static $snakeAttributes = false;

    protected $casts = [
        self::ID => 'int',
        self::MODEL_ID => 'int',
        self::YEAR => 'integer',
        self::MILEAGE => 'int',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime'
    ];

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, \App\Models\Car::MODEL_ID);
    }
}
