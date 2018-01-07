<?php

namespace App\Repositories;

use App\Models\FeePrice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FeePriceRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:44 pm UTC
 *
 * @method FeePrice findWithoutFail($id, $columns = ['*'])
 * @method FeePrice find($id, $columns = ['*'])
 * @method FeePrice first($columns = ['*'])
*/
class FeePriceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'port_id',
        'star_date',
        'end_date',
        'price'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FeePrice::class;
    }
}
