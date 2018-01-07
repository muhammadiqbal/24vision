<?php

namespace App\Repositories;

use App\Models\Bdi;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BdiRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:38 pm UTC
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
        'code',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bdi::class;
    }
}
