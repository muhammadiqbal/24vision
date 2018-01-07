<?php

namespace App\Repositories;

use App\Models\ZonePorts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ZonePortsRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:45 pm UTC
 *
 * @method ZonePorts findWithoutFail($id, $columns = ['*'])
 * @method ZonePorts find($id, $columns = ['*'])
 * @method ZonePorts first($columns = ['*'])
*/
class ZonePortsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'port_id',
        'zone_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ZonePorts::class;
    }
}
