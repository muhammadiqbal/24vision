<?php

namespace App\Repositories;

use App\Models\ZonePort;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ZonePortRepository
 * @package App\Repositories
 * @version January 7, 2018, 4:00 pm UTC
 *
 * @method ZonePort findWithoutFail($id, $columns = ['*'])
 * @method ZonePort find($id, $columns = ['*'])
 * @method ZonePort first($columns = ['*'])
*/
class ZonePortRepository extends BaseRepository
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
        return ZonePort::class;
    }
}
