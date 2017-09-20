<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ShipType
 * @package App\Models
 * @version September 10, 2017, 9:37 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Ship
 * @property string name
 */
class ShipType extends Model
{
    use SoftDeletes;

    public $table = 'ship_types';
    
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
    public function ships()
    {
        return $this->hasMany(\App\Models\Ship::class);
    }
}
