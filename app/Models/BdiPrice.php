<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BdiPrice
 * @package App\Models
 * @version January 7, 2018, 3:44 pm UTC
 *
 * @property \App\Models\Bdi bdi
 * @property \Illuminate\Database\Eloquent\Collection zonePorts
 * @property integer bdi_id
 * @property decimal price
 * @property date start_date
 * @property date end_date
 */
class BdiPrice extends Model
{
    use SoftDeletes;

    public $table = 'bdi_prices';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'bdi_id',
        'price',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'bdi_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date'
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
}
