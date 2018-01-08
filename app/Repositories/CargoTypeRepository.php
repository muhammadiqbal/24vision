<?php

namespace App\Repositories;

use App\Models\CargoType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CargoTypeRepository
 * @package App\Repositories
 * @version January 8, 2018, 8:35 am UTC
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
        'standard_stowage_factor'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CargoType::class;
    }
}
