<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Distance
 * @package App\Models
 * @version January 7, 2018, 3:46 pm UTC
 *
 * @property \App\Models\Port port
 * @property \App\Models\Path path
 * @property \App\Models\Port port
 * @property \Illuminate\Database\Eloquent\Collection zonePorts
 * @property integer start_port
 * @property integer end_port
 * @property decimal distance
 * @property integer path_id
 */
class Distance extends Model
{
    use SoftDeletes;

    public $table = 'distances';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'start_port',
        'end_port',
        'distance',
        'path_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start_port' => 'integer',
        'end_port' => 'integer',
        'path_id' => 'integer'
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
    public function path()
    {
        return $this->belongsTo(\App\Models\Path::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function port()
    {
        return $this->belongsTo(\App\Models\Port::class);
    }
}
