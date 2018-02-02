<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Port
 * @package App\Models
 * @version February 2, 2018, 9:58 pm UTC
 *
 * @property \App\Models\Zone zone
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection Distance
 * @property \Illuminate\Database\Eloquent\Collection Distance
 * @property \Illuminate\Database\Eloquent\Collection FeePrice
 * @property string name
 * @property integer zone_id
 * @property decimal max_laden_draft
 * @property decimal latitude
 * @property decimal longitude
 * @property decimal draft_factor
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
        'zone_id',
        'max_laden_draft',
        'latitude',
        'longitude',
        'draft_factor'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
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
    public function zone()
    {
        return $this->belongsTo(\App\Models\Zone::class);
    }

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
    public function cargos()
    {
        return $this->hasMany(\App\Models\Cargo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function distances()
    {
        return $this->hasMany(\App\Models\Distance::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function distances()
    {
        return $this->hasMany(\App\Models\Distance::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function feePrices()
    {
        return $this->hasMany(\App\Models\FeePrice::class);
    }
}
