<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ShipSpecialization
 * @package App\Models
 * @version September 10, 2017, 9:40 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection Ship
 * @property string name
 */
class ShipSpecialization extends Model
{
    use SoftDeletes;

    public $table = 'ship_specializations';
    
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
    public function ships()
    {
        return $this->hasMany(\App\Models\Ship::class);
    }
}
