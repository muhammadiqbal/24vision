<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Route
 * @package App\Models
 * @version December 3, 2017, 11:24 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection agreements
 * @property \Illuminate\Database\Eloquent\Collection Bdi
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property string code
 * @property string name
 * @property string area1
 * @property string area2
 * @property string area3
 */
class Route extends Model
{
    use SoftDeletes;

    public $table = 'routes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'name',
        'area1',
        'area2',
        'area3'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'area1' => 'string',
        'area2' => 'string',
        'area3' => 'string'
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
    public function bdis()
    {
        return $this->hasMany(\App\Models\Bdi::class);
    }
}
