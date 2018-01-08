<?php

namespace App\Repositories;

use App\Models\Route;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RouteRepository
 * @package App\Repositories
 * @version January 8, 2018, 10:03 am UTC
 *
 * @method Route findWithoutFail($id, $columns = ['*'])
 * @method Route find($id, $columns = ['*'])
 * @method Route first($columns = ['*'])
*/
class RouteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'bdi_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Route::class;
    }
}
