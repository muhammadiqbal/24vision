<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cargo
 * @package App\Models
 * @version January 8, 2018, 10:29 pm UTC
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
 * @property date laycan_last_day
 * @property boolean laycan_last_day_manual
 * @property integer cargo_type_id
 * @property boolean cargo_type_id_manual
 * @property integer stowage_factor
 * @property boolean stowage_factor_manual
 * @property integer sf_unit
 * @property boolean sf_unit_manual
 * @property integer ship_specialization_id
 * @property boolean ship_specialization_id_manual
 * @property integer quantity_measurement_id
 * @property boolean quantity_measurement_id_manual
 * @property integer quantity
 * @property boolean quantity_manual
 * @property integer loading_rate_type
 * @property boolean loading_rate_type_manual
 * @property integer loading_rate
 * @property boolean loading_rate_manual
 * @property integer discharging_rate_type
 * @property boolean discharging_rate_type_manual
 * @property integer discharging_rate
 * @property boolean discharging_rate_manual
 * @property string extra_condition
 * @property boolean extra_condition_manual
 * @property decimal comission
 * @property boolean commision_manual
 * @property integer emailId
 * @property boolean emailId_manual
 * @property integer status_id
 * @property boolean status_id_manual
 */
class Cargo extends Model
{
    use SoftDeletes;

    public $table = 'cargos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'loading_port',
        'loading_port_manual',
        'discharging_port',
        'discharging_port_manual',
        'laycan_first_day',
        'laycan_first_day_manual',
        'laycan_last_day',
        'laycan_last_day_manual',
        'cargo_type_id',
        'cargo_type_id_manual',
        'stowage_factor',
        'stowage_factor_manual',
        'sf_unit',
        'sf_unit_manual',
        'ship_specialization_id',
        'ship_specialization_id_manual',
        'quantity_measurement_id',
        'quantity_measurement_id_manual',
        'quantity',
        'quantity_manual',
        'loading_rate_type',
        'loading_rate_type_manual',
        'loading_rate',
        'loading_rate_manual',
        'discharging_rate_type',
        'discharging_rate_type_manual',
        'discharging_rate',
        'discharging_rate_manual',
        'extra_condition',
        'extra_condition_manual',
        'comission',
        'commision_manual',
        'emailId',
        'emailId_manual',
        'status_id',
        'status_id_manual'
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
        'laycan_last_day' => 'date',
        'laycan_last_day_manual' => 'boolean',
        'cargo_type_id' => 'integer',
        'cargo_type_id_manual' => 'boolean',
        'stowage_factor' => 'integer',
        'stowage_factor_manual' => 'boolean',
        'sf_unit' => 'integer',
        'sf_unit_manual' => 'boolean',
        'ship_specialization_id' => 'integer',
        'ship_specialization_id_manual' => 'boolean',
        'quantity_measurement_id' => 'integer',
        'quantity_measurement_id_manual' => 'boolean',
        'quantity' => 'integer',
        'quantity_manual' => 'boolean',
        'loading_rate_type' => 'integer',
        'loading_rate_type_manual' => 'boolean',
        'loading_rate' => 'integer',
        'loading_rate_manual' => 'boolean',
        'discharging_rate_type' => 'integer',
        'discharging_rate_type_manual' => 'boolean',
        'discharging_rate' => 'integer',
        'discharging_rate_manual' => 'boolean',
        'extra_condition' => 'string',
        'extra_condition_manual' => 'boolean',
        'commision_manual' => 'boolean',
        'emailId' => 'integer',
        'emailId_manual' => 'boolean',
        'status_id' => 'integer',
        'status_id_manual' => 'boolean'
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
    public function cargoType()
    {
        return $this->belongsTo(\App\Models\CargoType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function port()
    {
        return $this->belongsTo(\App\Models\Port::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function loadingDischargingRateType()
    {
        return $this->belongsTo(\App\Models\LoadingDischargingRateType::class);
    }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  **/
    // public function port()
    // {
    //     return $this->belongsTo(\App\Models\Port::class);
    // }

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
}
