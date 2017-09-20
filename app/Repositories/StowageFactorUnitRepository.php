<?php

namespace App\Repositories;

use App\Models\StowageFactorUnit;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StowageFactorUnitRepository
 * @package App\Repositories
 * @version September 10, 2017, 9:43 pm UTC
 *
 * @method StowageFactorUnit findWithoutFail($id, $columns = ['*'])
 * @method StowageFactorUnit find($id, $columns = ['*'])
 * @method StowageFactorUnit first($columns = ['*'])
*/
class StowageFactorUnitRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unit'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return StowageFactorUnit::class;
    }
}
