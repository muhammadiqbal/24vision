<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ZonePorts
 * @package App\Models
 * @version January 7, 2018, 3:45 pm UTC
 *
 * @property \App\Models\Port port
 * @property \App\Models\Zone zone
 * @property integer port_id
 * @property integer zone_id
 */
class ZonePorts extends Model
{
    use SoftDeletes;

    public $table = 'zone_ports';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'port_id',
        'zone_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'port_id' => 'integer',
        'zone_id' => 'integer'
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
    public function zone()
    {
        return $this->belongsTo(\App\Models\Zone::class);
    }
}
