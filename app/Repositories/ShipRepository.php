<?php

namespace App\Repositories;

use App\Models\Ship;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShipRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:42 pm UTC
 *
 * @method Ship findWithoutFail($id, $columns = ['*'])
 * @method Ship find($id, $columns = ['*'])
 * @method Ship first($columns = ['*'])
*/
class ShipRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'imo',
        'year_of_built',
        'dwcc',
        'max_holds_capacity',
        'max_laden_draft',
        'fuel_consumption_at_sea',
        'fuel_consumption_in_port',
        'flag',
        'ship_type_id',
        'ship_specialization_id',
        'gear_onboard',
        'additional_information'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ship::class;
    }
}
