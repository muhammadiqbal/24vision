<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Agreement
 * @package App\Models
 * @version October 14, 2017, 7:11 pm UTC
 *
 * @property \App\Models\Cargo cargo
 * @property \App\Models\ShipPosition shipPosition
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property integer ship_position_id
 * @property integer cargo_id
 */
class Agreement extends Model
{
    use SoftDeletes;

    public $table = 'agreements';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'ship_position_id',
        'cargo_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ship_position_id' => 'integer',
        'cargo_id' => 'integer'
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
    public function cargo()
    {
        return $this->belongsTo(\App\Models\Cargo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shipPosition()
    {
        return $this->belongsTo(\App\Models\ShipPosition::class);
    }
}
