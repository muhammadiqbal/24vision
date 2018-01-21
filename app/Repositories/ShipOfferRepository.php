<?php

namespace App\Repositories;

use App\Models\ShipOffer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShipOfferRepository
 * @package App\Repositories
 * @version January 8, 2018, 8:14 am UTC
 *
 * @method Ship findWithoutFail($id, $columns = ['*'])
 * @method Ship find($id, $columns = ['*'])
 * @method Ship first($columns = ['*'])
*/
class ShipOfferRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShipOffer::class;
    }
}
