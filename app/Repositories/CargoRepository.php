<?php

namespace App\Repositories;

use App\Models\Cargo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CargoRepository
 * @package App\Repositories
 * @version December 5, 2017, 11:30 am UTC
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
     * Configure the Model
     **/
    public function model()
    {
        return Cargo::class;
    }
}
