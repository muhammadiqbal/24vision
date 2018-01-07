<?php

namespace App\Repositories;

use App\Models\BdiPrice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BdiPriceRepository
 * @package App\Repositories
 * @version January 7, 2018, 3:44 pm UTC
 *
 * @method BdiPrice findWithoutFail($id, $columns = ['*'])
 * @method BdiPrice find($id, $columns = ['*'])
 * @method BdiPrice first($columns = ['*'])
*/
class BdiPriceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'bdi_id',
        'price',
        'start_date',
        'end_date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BdiPrice::class;
    }
}
