<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Route
 * @package App\Models
 * @version January 8, 2018, 10:03 am UTC
 *
 * @property \App\Models\Bdi bdi
 * @property \Illuminate\Database\Eloquent\Collection distances
 * @property \Illuminate\Database\Eloquent\Collection Path
 * @property string name
 * @property integer bdi_id
 */
class Route extends Model
{
    use SoftDeletes;

    public $table = 'routes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'bdi_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'bdi_id' => 'integer'
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
    public function bdi()
    {
        return $this->belongsTo(\App\Models\Bdi::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function paths()
    {
        return $this->hasMany(\App\Models\Path::class);
    }
}
