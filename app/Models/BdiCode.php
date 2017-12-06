<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BdiCode
 * @package App\Models
 * @version December 5, 2017, 11:27 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Bdi
 * @property string code
 * @property string name
 */
class BdiCode extends Model
{
    use SoftDeletes;

    public $table = 'bdi_codes';
    
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
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function bdis()
    {
        return $this->hasMany(\App\Models\Bdi::class);
    }
}
