<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cargo
 * @package App\Models
 * @version December 5, 2017, 11:30 am UTC
 *
 * @property \App\Models\Customer customer
 * @property \App\Models\Port port
 * @property \App\Models\LoadingDischargingRateType loadingDischargingRateType
 * @property \App\Models\FreightIdeaMeasurement freightIdeaMeasurement
 * @property \App\Models\Port port
 * @property \App\Models\LoadingDischargingRateType loadingDischargingRateType
 * @property \App\Models\QuantityMeasurement quantityMeasurement
 * @property \App\Models\StowageFactorUnit stowageFactorUnit
 * @property \App\Models\ShipSpecialization shipSpecialization
 * @property \Illuminate\Database\Eloquent\Collection bdi
 * @property integer customer_id
 * @property integer loading_port
 * @property integer discharging_port
 * @property date laycan_first_day
 * @property date laycan_last_day
 * @property string cargo_description
 * @property integer stowage_factor
 * @property integer sf_unit
 * @property integer ship_specialization_id
 * @property integer quantity_measurement_id
 * @property integer quantity
 * @property integer loading_rate_type
 * @property integer loading_rate
 * @property integer discharging_rate_type
 * @property integer discharging_rate
 * @property integer freight_idea_measurement_id
 * @property integer freight_idea
 * @property string extra_condition
 * @property decimal comission
 */
class Cargo extends Model
{

    /*START non db attrobites */
    protected $ntce;
    protected $grossRate;
    protected $ntc;
    protected $route;//later we need relation for this 
    /*END non db attribute*/


    use SoftDeletes;

    public $table = 'cargos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'customer_id',
        'loading_port',
        'discharging_port',
        'laycan_first_day',
        'laycan_last_day',
        'cargo_description',
        'stowage_factor',
        'sf_unit',
        'ship_specialization_id',
        'quantity_measurement_id',
        'quantity',
        'loading_rate_type',
        'loading_rate',
        'discharging_rate_type',
        'discharging_rate',
        'freight_idea_measurement_id',
        'freight_idea',
        'extra_condition',
        'comission'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'customer_id' => 'integer',
        'loading_port' => 'integer',
        'discharging_port' => 'integer',
        'laycan_first_day' => 'date',
        'laycan_last_day' => 'date',
        'cargo_description' => 'string',
        'stowage_factor' => 'integer',
        'sf_unit' => 'integer',
        'ship_specialization_id' => 'integer',
        'quantity_measurement_id' => 'integer',
        'quantity' => 'integer',
        'loading_rate_type' => 'integer',
        'loading_rate' => 'integer',
        'discharging_rate_type' => 'integer',
        'discharging_rate' => 'integer',
        'freight_idea_measurement_id' => 'integer',
        'freight_idea' => 'integer',
        'extra_condition' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /*START non db attribute setter and getter*/
    public function setNtce($ntce){
        $this->ntce = $ntce;
    }

    public function getNtce(){
        return $this->ntce;
    }

    public function setGrossRate($grossRate){
        $this->grossRate = $grossRate;
    }

    public function getGrossRate(){
        return $this->grossRate;
    }

    public function setNtc($ntc){
         $this->ntc = $ntc;
    }

    public function getNtc(){
        return $this->ntc;
    }

    public function setRoute(Route $route){
         $this->route = $route;
    }

    public function getRoute(){
        return $this->route;
    }
    /*END non db attribute setter and getter*/


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  **/
    // public function loadingDischargingRateType()
    // {
    //     return $this->belongsTo(\App\Models\LoadingDischargingRateType::class);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function freightIdeaMeasurement()
    {
        return $this->belongsTo(\App\Models\FreightIdeaMeasurement::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function loadingPort()
    {
        return $this->belongsTo(\App\Models\Port::class,'loading_port');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function dischargingPort()
    {
        return $this->belongsTo(\App\Models\Port::class,'discharging_port');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function loadingDischargingRateType()
    {
        return $this->belongsTo(\App\Models\LoadingDischargingRateType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function quantityMeasurement()
    {
        return $this->belongsTo(\App\Models\QuantityMeasurement::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function stowageFactorUnit()
    {
        return $this->belongsTo(\App\Models\StowageFactorUnit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shipSpecialization()
    {
        return $this->belongsTo(\App\Models\ShipSpecialization::class);
    }
}
