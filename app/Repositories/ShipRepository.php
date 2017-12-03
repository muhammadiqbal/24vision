<?php

namespace App\Repositories;

use App\Models\Ship;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShipRepository
 * @package App\Repositories
 * @version December 3, 2017, 3:00 pm UTC
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
     * Configure the Model
     **/
    public function model()
    {
        return Ship::class;
    }
}
