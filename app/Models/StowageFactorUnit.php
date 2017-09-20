<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StowageFactorUnit
 * @package App\Models
 * @version September 10, 2017, 9:43 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property string unit
 */
class StowageFactorUnit extends Model
{
    use SoftDeletes;

    public $table = 'stowage_factor_units';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'unit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function cargos()
    {
        return $this->hasMany(\App\Models\Cargo::class);
    }
}
