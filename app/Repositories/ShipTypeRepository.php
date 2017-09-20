<?php

namespace App\Repositories;

use App\Models\ShipType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShipTypeRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:37 pm UTC
 *
 * @method ShipType findWithoutFail($id, $columns = ['*'])
 * @method ShipType find($id, $columns = ['*'])
 * @method ShipType first($columns = ['*'])
*/
class ShipTypeRepository extends BaseRepository
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
        return ShipType::class;
    }
}
