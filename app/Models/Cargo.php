<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cargo
 * @package App\Models
 * @version January 10, 2018, 9:27 am UTC
 *
 * @property \App\Models\CargoType cargoType
 * @property \App\Models\Port port
 * @property \App\Models\LoadingDischargingRateType loadingDischargingRateType
 * @property \App\Models\Port port
 * @property \App\Models\LoadingDischargingRateType loadingDischargingRateType
 * @property \App\Models\QuantityMeasurement quantityMeasurement
 * @property \App\Models\StowageFactorUnit stowageFactorUnit
 * @property \App\Models\ShipSpecialization shipSpecialization
 * @property \App\Models\CargoStatus cargoStatus
 * @property \Illuminate\Database\Eloquent\Collection distances
 * @property integer loading_port
 * @property boolean loading_port_manual
 * @property integer discharging_port
 * @property boolean discharging_port_manual
 * @property date laycan_first_day
 * @property boolean laycan_first_day_manual
 * @property boolean laycan_first_day_constructed
 * @property date laycan_last_day
 * @property boolean laycan_last_day_manual
 * @property boolean laycan_last_day_constructed
 * @property integer cargo_type_id
 * @property boolean cargo_type_id_manual
 * @property decimal stowage_factor
 * @property boolean stowage_factor_manual
 * @property boolean stowage_factor_constructed
 * @property integer sf_unit
 * @property integer ship_specialization_id
 * @property integer quantity_measurement_id
 * @property integer quantity
 * @property boolean quantity_manual
 * @property boolean quantity_constructed
 * @property integer loading_rate_type
 * @property boolean loading_rate_type_manual
 * @property integer loading_rate
 * @property boolean loading_rate_manual
 * @property boolean loading_rate_constructed
 * @property integer discharging_rate_type
 * @property boolean discharging_rate_type_manual
 * @property integer discharging_rate
 * @property boolean discharging_rate_manual
 * @property boolean discharging_rate_constructed
 * @property string extra_condition
 * @property decimal commission
 * @property boolean commision_manual
 * @property boolean commision_constructed
 * @property integer email_id
 * @property integer status_id
 */
class Cargo extends Model
{
    use SoftDeletes;

    public $table = 'cargos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    /*START non db attributes */
    protected $ntce;
    protected $grossRate;
    protected $ntc;
    protected $route;
    /*END non db attributes*/


    public $fillable = [
        'loading_port',
        'loading_port_manual',
        'discharging_port',
        'discharging_port_manual',
        'laycan_first_day',
        'laycan_first_day_manual',
        'laycan_first_day_constructed',
        'laycan_last_day',
        'laycan_last_day_manual',
        'laycan_last_day_constructed',
        'cargo_type_id',
        'cargo_type_id_manual',
        'stowage_factor',
        'stowage_factor_manual',
        'stowage_factor_constructed',
        'sf_unit',
        'ship_specialization_id',
        'quantity_measurement_id',
        'quantity',
        'quantity_manual',
        'quantity_constructed',
        'loading_rate_type',
        'loading_rate_type_manual',
        'loading_rate',
        'loading_rate_manual',
        'loading_rate_constructed',
        'discharging_rate_type',
        'discharging_rate_type_manual',
        'discharging_rate',
        'discharging_rate_manual',
        'discharging_rate_constructed',
        'extra_condition',
        'commission',
        'commision_manual',
        'commision_constructed',
        'email_id',
        'status_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'loading_port' => 'integer',
        'loading_port_manual' => 'boolean',
        'discharging_port' => 'integer',
        'discharging_port_manual' => 'boolean',
        'laycan_first_day' => 'date',
        'laycan_first_day_manual' => 'boolean',
        'laycan_first_day_constructed' => 'boolean',
        'laycan_last_day' => 'date',
        'laycan_last_day_manual' => 'boolean',
        'laycan_last_day_constructed' => 'boolean',
        'cargo_type_id' => 'integer',
        'cargo_type_id_manual' => 'boolean',
        'stowage_factor_manual' => 'boolean',
        'stowage_factor_constructed' => 'boolean',
        'sf_unit' => 'integer',
        'ship_specialization_id' => 'integer',
        'quantity_measurement_id' => 'integer',
        'quantity' => 'integer',
        'quantity_manual' => 'boolean',
        'quantity_constructed' => 'boolean',
        'loading_rate_type' => 'integer',
        'loading_rate_type_manual' => 'boolean',
        'loading_rate' => 'integer',
        'loading_rate_manual' => 'boolean',
        'loading_rate_constructed' => 'boolean',
        'discharging_rate_type' => 'integer',
        'discharging_rate_type_manual' => 'boolean',
        'discharging_rate' => 'integer',
        'discharging_rate_manual' => 'boolean',
        'discharging_rate_constructed' => 'boolean',
        'extra_condition' => 'string',
        'commision_manual' => 'boolean',
        'commision_constructed' => 'boolean',
        'email_id' => 'integer',
        'status_id' => 'integer'
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
    public function cargoType()
    {
        return $this->belongsTo(\App\Models\CargoType::class);
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cargoStatus()
    {
        return $this->belongsTo(\App\Models\CargoStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function email()
    {
        return $this->belongsTo(\App\Models\Email::class,'email_id');
    }
}
