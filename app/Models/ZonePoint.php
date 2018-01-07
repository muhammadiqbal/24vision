<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ZonePoint
 * @package App\Models
 * @version January 7, 2018, 3:45 pm UTC
 *
 * @property \App\Models\Port port
 * @property \Illuminate\Database\Eloquent\Collection zonePorts
 * @property integer port_id
 * @property decimal latitude
 * @property decimal longitude
 */
class ZonePoint extends Model
{
    use SoftDeletes;

    public $table = 'zone_points';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'port_id',
        'latitude',
        'longitude'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'port_id' => 'integer'
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
}
