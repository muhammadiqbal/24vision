<?php

namespace App\Repositories;

use App\Models\ShipPosition;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShipPositionRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:47 pm UTC
 *
 * @method ShipPosition findWithoutFail($id, $columns = ['*'])
 * @method ShipPosition find($id, $columns = ['*'])
 * @method ShipPosition first($columns = ['*'])
*/
class ShipPositionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ship_id',
        'region_id',
        'port_id',
        'date_of_opening'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShipPosition::class;
    }
}
