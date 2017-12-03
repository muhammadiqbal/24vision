<?php

namespace App\Repositories;

use App\Models\Bdi;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BdiRepository
 * @package App\Repositories
 * @version December 3, 2017, 11:25 am UTC
 *
 * @method Bdi findWithoutFail($id, $columns = ['*'])
 * @method Bdi find($id, $columns = ['*'])
 * @method Bdi first($columns = ['*'])
*/
class BdiRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ship_id',
        'route_id',
        'price',
        'start_date',
        'end_date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bdi::class;
    }
}
