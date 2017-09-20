<?php

namespace App\Repositories;

use App\Models\Port;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PortRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:42 pm UTC
 *
 * @method Port findWithoutFail($id, $columns = ['*'])
 * @method Port find($id, $columns = ['*'])
 * @method Port first($columns = ['*'])
*/
class PortRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Port::class;
    }
}
