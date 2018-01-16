<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Zone
 * @package App\Models
 * @version January 7, 2018, 3:39 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Path
 * @property \Illuminate\Database\Eloquent\Collection Path
 * @property \Illuminate\Database\Eloquent\Collection Path
 * @property \Illuminate\Database\Eloquent\Collection Port
 * @property \Illuminate\Database\Eloquent\Collection Route
 * @property \Illuminate\Database\Eloquent\Collection Route
 * @property \Illuminate\Database\Eloquent\Collection Route
 * @property \Illuminate\Database\Eloquent\Collection ZonePort
 * @property string name
 */
class Zone extends Model
{
    use SoftDeletes;

    public $table = 'zones';
    
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
    public function paths()
    {
        return $this->hasMany(\App\Models\Path::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function ports()
    {
        return $this->hasMany(\App\Models\Port::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function routes()
    {
        return $this->hasMany(\App\Models\Route::class);
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function zonePorts()
    {
        return $this->hasMany(\App\Models\ZonePort::class);
    }
}
