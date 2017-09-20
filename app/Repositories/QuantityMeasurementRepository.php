<?php

namespace App\Repositories;

use App\Models\QuantityMeasurement;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class QuantityMeasurementRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:44 pm UTC
 *
 * @method QuantityMeasurement findWithoutFail($id, $columns = ['*'])
 * @method QuantityMeasurement find($id, $columns = ['*'])
 * @method QuantityMeasurement first($columns = ['*'])
*/
class QuantityMeasurementRepository extends BaseRepository
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
        return QuantityMeasurement::class;
    }
}
