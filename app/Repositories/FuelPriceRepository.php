<?php

namespace App\Repositories;

use App\Models\FuelPrice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FuelPriceRepository
 * @package App\Repositories
 * @version December 3, 2017, 11:25 am UTC
 *
 * @method FuelPrice findWithoutFail($id, $columns = ['*'])
 * @method FuelPrice find($id, $columns = ['*'])
 * @method FuelPrice first($columns = ['*'])
*/
class FuelPriceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fuel_type_id',
        'price',
        'start_date',
        'end_date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FuelPrice::class;
    }
}
