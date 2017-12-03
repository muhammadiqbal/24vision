<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bdi
 * @package App\Models
 * @version December 3, 2017, 11:25 am UTC
 *
 * @property \App\Models\Route route
 * @property \App\Models\Ship ship
 * @property \Illuminate\Database\Eloquent\Collection agreements
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property integer ship_id
 * @property integer route_id
 * @property decimal price
 * @property date start_date
 * @property date end_date
 */
class Bdi extends Model
{
    use SoftDeletes;

    public $table = 'bdi';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'ship_id',
        'route_id',
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
        'ship_id' => 'integer',
        'route_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function route()
    {
        return $this->belongsTo(\App\Models\Route::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function ship()
    {
        return $this->belongsTo(\App\Models\Ship::class);
    }
}
