<?php

namespace App\Repositories;

use App\Models\LdRateType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LdRateTypeRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:46 pm UTC
 *
 * @method LdRateType findWithoutFail($id, $columns = ['*'])
 * @method LdRateType find($id, $columns = ['*'])
 * @method LdRateType first($columns = ['*'])
*/
class LdRateTypeRepository extends BaseRepository
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
        return LdRateType::class;
    }
}
