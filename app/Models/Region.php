<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Region
 * @package App\Models
 * @version September 10, 2017, 9:42 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection ShipPosition
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property string name
 */
class Region extends Model
{
    use SoftDeletes;

    public $table = 'regions';
    
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
    public function shipPositions()
    {
        return $this->hasMany(\App\Models\ShipPosition::class);
    }
}
