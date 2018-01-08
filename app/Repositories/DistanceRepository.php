<?php

namespace App\Repositories;

use App\Models\Distance;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DistanceRepository
 * @package App\Repositories
 * @version January 8, 2018, 10:03 am UTC
 *
 * @method Distance findWithoutFail($id, $columns = ['*'])
 * @method Distance find($id, $columns = ['*'])
 * @method Distance first($columns = ['*'])
*/
class DistanceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'start_port',
        'end_port',
        'distance'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Distance::class;
    }
}
