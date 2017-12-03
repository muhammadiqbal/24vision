<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ship
 * @package App\Models
 * @version December 3, 2017, 3:00 pm UTC
 *
 * @property \App\Models\FuelType fuelType
 * @property \App\Models\ShipSpecialization shipSpecialization
 * @property \App\Models\ShipType shipType
 * @property \Illuminate\Database\Eloquent\Collection Bdi
 * @property \Illuminate\Database\Eloquent\Collection ShipPosition
 * @property string name
 * @property string imo
 * @property date year_of_build
 * @property integer dwcc
 * @property decimal max_holds_capacity
 * @property decimal ballast_draft
 * @property decimal max_laden_draft
 * @property decimal speed_laden
 * @property decimal speed_ballast
 * @property integer fuel_type_id
 * @property decimal fuel_consumption_at_sea
 * @property decimal fuel_consumption_in_port
 * @property string flag
 * @property integer ship_type_id
 * @property integer ship_specialization_id
 * @property string gear_onboard
 * @property string additional_information
 */
class Ship extends Model
{
    use SoftDeletes;

    public $table = 'ships';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'imo',
        'year_of_build',
        'dwcc',
        'max_holds_capacity',
        'ballast_draft',
        'max_laden_draft',
        'speed_laden',
        'speed_ballast',
        'fuel_type_id',
        'fuel_consumption_at_sea',
        'fuel_consumption_in_port',
        'flag',
        'ship_type_id',
        'ship_specialization_id',
        'gear_onboard',
        'additional_information'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'imo' => 'string',
        'year_of_build' => 'date',
        'dwcc' => 'integer',
        'fuel_type_id' => 'integer',
        'flag' => 'string',
        'ship_type_id' => 'integer',
        'ship_specialization_id' => 'integer',
        'gear_onboard' => 'string',
        'additional_information' => 'string'
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
    public function fuelType()
    {
        return $this->belongsTo(\App\Models\FuelType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shipSpecialization()
    {
        return $this->belongsTo(\App\Models\ShipSpecialization::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shipType()
    {
        return $this->belongsTo(\App\Models\ShipType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function bdis()
    {
        return $this->hasMany(\App\Models\Bdi::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function shipPositions()
    {
        return $this->hasMany(\App\Models\ShipPosition::class);
    }
}
