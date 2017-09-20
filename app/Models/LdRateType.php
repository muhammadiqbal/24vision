<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LdRateType
 * @package App\Models
 * @version September 10, 2017, 9:46 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property string name
 */
class LdRateType extends Model
{
    use SoftDeletes;

    public $table = 'loading_dischaging_rate_type';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
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
        
    ];

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
}
