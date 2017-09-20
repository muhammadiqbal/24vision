<?php

namespace App\Repositories;

use App\Models\ShipSpecialization;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShipSpecializationRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:40 pm UTC
 *
 * @method ShipSpecialization findWithoutFail($id, $columns = ['*'])
 * @method ShipSpecialization find($id, $columns = ['*'])
 * @method ShipSpecialization first($columns = ['*'])
*/
class ShipSpecializationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShipSpecialization::class;
    }
}
