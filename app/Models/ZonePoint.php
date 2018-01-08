<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ZonePoint
 * @package App\Models
 * @version January 8, 2018, 8:14 am UTC
 *
 * @property \App\Models\Zone zone
 * @property integer zone_id
 * @property decimal latitude
 * @property decimal longitude
 * @property integer position
 */
class ZonePoint extends Model
{
    use SoftDeletes;

    public $table = 'zone_points';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'zone_id',
        'latitude',
        'longitude',
        'position'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'zone_id' => 'integer',
        'position' => 'integer'
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
    public function zone()
    {
        return $this->belongsTo(\App\Models\Zone::class);
    }
}
