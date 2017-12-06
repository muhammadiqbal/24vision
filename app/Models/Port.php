<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Port
 * @package App\Models
 * @version December 5, 2017, 1:40 pm UTC
 *
 * @property \App\Models\Region region
 * @property \App\Models\Region region
 * @property \Illuminate\Database\Eloquent\Collection bdi
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection ShipPosition
 * @property string name
 * @property integer fee
 * @property integer region_id
 * @property decimal max_laden_draft
 * @property decimal latitude
 * @property decimal longitude
 */
class Port extends Model
{
    use SoftDeletes;

    public $table = 'ports';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'fee',
        'region_id',
        'max_laden_draft',
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
        'name' => 'string',
        'fee' => 'integer',
        'region_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  **/
    // public function region()
    // {
    //     return $this->belongsTo(\App\Models\Region::class);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class);
    }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  **/
    // public function cargos()
    // {
    //     return $this->hasMany(\App\Models\Cargo::class);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function cargos()
    {
        return $this->hasMany(\App\Models\Cargo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function shipPositions()
    {
        return $this->hasMany(\App\Models\ShipPosition::class);
    }
}
