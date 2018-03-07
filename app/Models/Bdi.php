<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bdi
 * @package App\Models
 * @version January 7, 2018, 3:38 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection BdiPrice
 * @property \Illuminate\Database\Eloquent\Collection zonePorts
 * @property string code
 * @property string name
 */
class Bdi extends Model
{
    use SoftDeletes;

    public $table = 'bdi';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'requred|string',
        'name' => 'requred|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function bdiPrices()
    {
        return $this->hasMany(\App\Models\BdiPrice::class);
    }
}
