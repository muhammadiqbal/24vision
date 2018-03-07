<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LdRateType
 * @package App\Models
 * @version January 8, 2018, 8:11 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property string name
 * @property decimal rate_type_factor
 */
class LdRateType extends Model
{
    use SoftDeletes;

    public $table = 'loading_discharging_rate_type';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'rate_type_factor'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function cargos()
    {
        return $this->hasMany(\App\Models\Cargo::class);
    }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  **/
    // public function cargos()
    // {
    //     return $this->hasMany(\App\Models\Cargo::class);
    // }
}
