<?php

namespace App\Repositories;

use App\Models\ZonePoint;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ZonePointRepository
 * @package App\Repositories
 * @version January 8, 2018, 8:14 am UTC
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
        'zone_id',
        'latitude',
        'longitude',
        'position'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ZonePoint::class;
    }
}
