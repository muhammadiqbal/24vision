<?php

namespace App\Repositories;

use App\Models\ShipOfferExtracted;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShipOfferExtractedRepository
 * @package App\Repositories
 * @version January 8, 2018, 8:14 am UTC
 *
 * @method Ship findWithoutFail($id, $columns = ['*'])
 * @method Ship find($id, $columns = ['*'])
 * @method Ship first($columns = ['*'])
*/
class ShipOfferExtractedRepository extends BaseRepository
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
        return ShipOfferExtracted::class;
    }
}
