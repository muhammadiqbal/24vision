<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ShipPosition
 * @package App\Models
 * @version October 14, 2017, 9:08 pm UTC
 *
 * @property \App\Models\Port port
 * @property \App\Models\Region region
 * @property \App\Models\Ship ship
 * @property \Illuminate\Database\Eloquent\Collection Agreement
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property integer ship_id
 * @property integer region_id
 * @property integer port_id
 * @property date date_of_opening
 */
class ShipPosition extends Model
{
    use SoftDeletes;

    public $table = 'ship_positions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'ship_id',
        'region_id',
        'port_id',
        'date_of_opening'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ship_id' => 'integer',
        'region_id' => 'integer',
        'port_id' => 'integer',
        'date_of_opening' => 'date'
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
    public function port()
    {
        return $this->belongsTo(\App\Models\Port::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function ship()
    {
        return $this->belongsTo(\App\Models\Ship::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function agreements()
    {
        return $this->hasMany(\App\Models\Agreement::class);
    }
}
