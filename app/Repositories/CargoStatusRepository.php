<?php

namespace App\Repositories;

use App\Models\CargoStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CargoStatusRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:41 pm UTC
 *
 * @method CargoStatus findWithoutFail($id, $columns = ['*'])
 * @method CargoStatus find($id, $columns = ['*'])
 * @method CargoStatus first($columns = ['*'])
*/
class CargoStatusRepository extends BaseRepository
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
        return CargoStatus::class;
    }
}
