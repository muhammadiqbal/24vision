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
        'area1' => 'integer',
        'area2' => 'integer',
        'area3' => 'integer'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function area1()
    {
        return $this->belongsTo(\App\Models\Region::class,'area1');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function area2()
    {
        return $this->belongsTo(\App\Models\Region::class,'area2');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function area3()
    {
        return $this->belongsTo(\App\Models\Region::class,'area3');
    }

}
