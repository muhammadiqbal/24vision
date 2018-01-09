<?php

namespace App\Repositories;

use App\Models\CargoType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CargoTypeRepository
 * @package App\Repositories
 * @version January 9, 2018, 7:26 pm UTC
 *
 * @method CargoType findWithoutFail($id, $columns = ['*'])
 * @method CargoType find($id, $columns = ['*'])
 * @method CargoType first($columns = ['*'])
*/
class CargoTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'stowage_factor',
        'sf_unit'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CargoType::class;
    }
}
