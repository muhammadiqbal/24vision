<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Path
 * @package App\Models
 * @version January 7, 2018, 3:46 pm UTC
 *
 * @property \App\Models\Route route
 * @property \App\Models\Zone zone
 * @property \App\Models\Zone zone
 * @property \App\Models\Zone zone
 * @property \Illuminate\Database\Eloquent\Collection Distance
 * @property \Illuminate\Database\Eloquent\Collection zonePorts
 * @property integer route_id
 * @property integer zone1
 * @property integer zone2
 * @property integer zone3
 */
class Path extends Model
{
    use SoftDeletes;

    public $table = 'paths';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'route_id',
        'zone1',
        'zone2',
        'zone3'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'route_id' => 'integer',
        'zone1' => 'integer',
        'zone2' => 'integer',
        'zone3' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'route_id' => 'required|integer',
        'zone1' => 'required|integer',
        'zone2' => 'integer',
        'zone3' => 'required|integer'
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
    public function zone1()
    {
        return $this->belongsTo(\App\Models\Zone::class,'zone1');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function zone2()
    {
        return $this->belongsTo(\App\Models\Zone::class,'zone2');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function zone3()
    {
        return $this->belongsTo(\App\Models\Zone::class,'zone3');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function distances()
    {
        return $this->hasMany(\App\Models\Distance::class);
    }
}
