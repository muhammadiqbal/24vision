<?php

namespace App\Repositories;

use App\Models\ShipOrder;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShipOrderRepository
 * @package App\Repositories
 * @version January 8, 2018, 8:14 am UTC
 *
 * @method Ship findWithoutFail($id, $columns = ['*'])
 * @method Ship find($id, $columns = ['*'])
 * @method Ship first($columns = ['*'])
*/
class ShipOrderRepository extends BaseRepository
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
        return ShipOrder::class;
    }
}
