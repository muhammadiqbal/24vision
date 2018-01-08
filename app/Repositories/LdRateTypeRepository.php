<?php

namespace App\Repositories;

use App\Models\LdRateType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LdRateTypeRepository
 * @package App\Repositories
 * @version January 8, 2018, 8:11 am UTC
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
        'name',
        'rate_type_factor'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LdRateType::class;
    }
}
