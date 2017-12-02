<?php

namespace App\Repositories;

use App\Models\Agreement;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AgreementRepository
 * @package App\Repositories
 * @version October 14, 2017, 7:11 pm UTC
 *
 * @method Agreement findWithoutFail($id, $columns = ['*'])
 * @method Agreement find($id, $columns = ['*'])
 * @method Agreement first($columns = ['*'])
*/
class AgreementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ship_position_id',
        'cargo_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Agreement::class;
    }
}
