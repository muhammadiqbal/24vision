<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bdi
 * @package App\Models
 * @version December 5, 2017, 11:27 am UTC
 *
 * @property \App\Models\BdiCode bdiCode
 * @property \App\Models\Ship ship
 * @property integer bdi_code_id
 * @property integer ship_id
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
        'bdi_code_id',
        'ship_id',
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
        'bdi_code_id' => 'integer',
        'ship_id' => 'integer',
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
    public function bdiCode()
    {
        return $this->belongsTo(\App\Models\BdiCode::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function ship()
    {
        return $this->belongsTo(\App\Models\Ship::class);
    }
}
