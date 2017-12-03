<?php

namespace App\Repositories;

use App\Models\Route;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RouteRepository
 * @package App\Repositories
 * @version December 3, 2017, 11:24 am UTC
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
        'code',
        'name',
        'area1',
        'area2',
        'area3'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Route::class;
    }
}
