<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FeePrice
 * @package App\Models
 * @version January 7, 2018, 3:44 pm UTC
 *
 * @property \App\Models\Port port
 * @property \Illuminate\Database\Eloquent\Collection zonePorts
 * @property integer port_id
 * @property date star_date
 * @property date end_date
 * @property decimal price
 */
class FeePrice extends Model
{
    use SoftDeletes;

    public $table = 'fee_prices';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'port_id',
        'star_date',
        'end_date',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'port_id' => 'integer',
        'star_date' => 'date',
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
    public function port()
    {
        return $this->belongsTo(\App\Models\Port::class);
    }
}
