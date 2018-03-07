<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FuelPrice
 * @package App\Models
 * @version December 3, 2017, 11:25 am UTC
 *
 * @property \App\Models\FuelType fuelType
 * @property \Illuminate\Database\Eloquent\Collection agreements
 * @property \Illuminate\Database\Eloquent\Collection bdi
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property integer fuel_type_id
 * @property decimal price
 * @property date start_date
 * @property date end_date
 */
class FuelPrice extends Model
{
    use SoftDeletes;

    public $table = 'fuel_prices';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'fuel_type_id',
        'price',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fuel_type_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'fuel_type_id' => 'required|integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'required|numeric'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function fuelType()
    {
        return $this->belongsTo(\App\Models\FuelType::class);
    }
}
