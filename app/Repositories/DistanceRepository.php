<?php

namespace App\Repositories;

use App\Models\Distance;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DistanceRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:46 pm UTC
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
        'distance',
        'path_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Distance::class;
    }
}
