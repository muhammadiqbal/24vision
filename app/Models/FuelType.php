<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FuelType
 * @package App\Models
 * @version December 3, 2017, 11:25 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection agreements
 * @property \Illuminate\Database\Eloquent\Collection bdi
 * @property \Illuminate\Database\Eloquent\Collection FuelPrice
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property string name
 */
class FuelType extends Model
{
    use SoftDeletes;

    public $table = 'fuel_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function fuelPrices()
    {
        return $this->hasMany(\App\Models\FuelPrice::class);
    }
}
