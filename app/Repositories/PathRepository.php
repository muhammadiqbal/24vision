<?php

namespace App\Repositories;

use App\Models\Path;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PathRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:46 pm UTC
 *
 * @method Path findWithoutFail($id, $columns = ['*'])
 * @method Path find($id, $columns = ['*'])
 * @method Path first($columns = ['*'])
*/
class PathRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'route_id',
        'zone1',
        'zone2',
        'zone3'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Path::class;
    }
}
