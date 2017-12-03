<?php

namespace App\Repositories;

use App\Models\FuelType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FuelTypeRepository
 * @package App\Repositories
 * @version December 3, 2017, 11:25 am UTC
 *
 * @method FuelType findWithoutFail($id, $columns = ['*'])
 * @method FuelType find($id, $columns = ['*'])
 * @method FuelType first($columns = ['*'])
*/
class FuelTypeRepository extends BaseRepository
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
        return FuelType::class;
    }
}
