<?php

namespace App\Repositories;

use App\Models\FreightIdeaMeasurement;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FreightIdeaMeasurementRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:46 pm UTC
 *
 * @method FreightIdeaMeasurement findWithoutFail($id, $columns = ['*'])
 * @method FreightIdeaMeasurement find($id, $columns = ['*'])
 * @method FreightIdeaMeasurement first($columns = ['*'])
*/
class FreightIdeaMeasurementRepository extends BaseRepository
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
        return FreightIdeaMeasurement::class;
    }
}
