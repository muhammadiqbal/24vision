<?php

namespace App\Repositories;

use App\Models\Port;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PortRepository
 * @package App\Repositories
 * @version February 2, 2018, 9:58 pm UTC
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
        'zone_id',
        'max_laden_draft',
        'latitude',
        'longitude',
        'draft_factor'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Port::class;
    }
}
