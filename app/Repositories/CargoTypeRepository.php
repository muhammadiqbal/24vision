<?php

namespace App\Repositories;

use App\Models\CargoType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CargoTypeRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:43 pm UTC
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
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CargoType::class;
    }
}
