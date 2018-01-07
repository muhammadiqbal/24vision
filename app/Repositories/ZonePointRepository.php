<?php

namespace App\Repositories;

use App\Models\ZonePoint;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ZonePointRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:45 pm UTC
 *
 * @method ZonePoint findWithoutFail($id, $columns = ['*'])
 * @method ZonePoint find($id, $columns = ['*'])
 * @method ZonePoint first($columns = ['*'])
*/
class ZonePointRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'port_id',
        'latitude',
        'longitude'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ZonePoint::class;
    }
}
