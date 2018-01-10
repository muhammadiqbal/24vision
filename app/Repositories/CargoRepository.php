<?php

namespace App\Repositories;

use App\Models\Cargo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CargoRepository
 * @package App\Repositories
 * @version January 10, 2018, 9:27 am UTC
 *
 * @method Cargo findWithoutFail($id, $columns = ['*'])
 * @method Cargo find($id, $columns = ['*'])
 * @method Cargo first($columns = ['*'])
*/
class CargoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return Cargo::class;
    }
}
