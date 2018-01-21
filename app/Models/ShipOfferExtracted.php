<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOfferExtracted extends Model
{
    //
    protected $connection = 'mysql2';

    public $table = 'ship_offer_extracted';

    protected $primaryKey = '';

    public $fillable = [
       
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
