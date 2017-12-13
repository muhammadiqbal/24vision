<?php

namespace App\Repositories;

use App\Models\BdiCode;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BdiCodeRepository
 * @package App\Repositories
 * @version December 5, 2017, 11:27 am UTC
 *
 * @method BdiCode findWithoutFail($id, $columns = ['*'])
 * @method BdiCode find($id, $columns = ['*'])
 * @method BdiCode first($columns = ['*'])
*/
class BdiCodeRepository extends BaseRepository
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
        return BdiCode::class;
    }
}
