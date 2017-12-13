<?php

namespace App\Repositories;

use App\Models\Port;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PortRepository
 * @package App\Repositories
 * @version December 5, 2017, 1:40 pm UTC
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
        'name',
        'fee',
        'region_id',
        'max_laden_draft',
        'latitude',
        'longitude'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Port::class;
    }
}
