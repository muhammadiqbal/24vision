<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CargoType
 * @package App\Models
 * @version January 9, 2018, 7:26 pm UTC
 *
 * @property \App\Models\StowageFactorUnit stowageFactorUnit
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection distances
 * @property string name
 * @property integer stowage_factor
 * @property integer sf_unit
 */
class CargoType extends Model
{
    use SoftDeletes;

    public $table = 'cargo_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'stowage_factor',
        'sf_unit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'stowage_factor' => 'integer',
        'sf_unit' => 'integer'
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
    public function stowageFactorUnit()
    {
        return $this->belongsTo(\App\Models\StowageFactorUnit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function cargos()
    {
        return $this->hasMany(\App\Models\Cargo::class);
    }
}
