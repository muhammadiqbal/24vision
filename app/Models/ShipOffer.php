<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOffer extends Model
{
    //
    protected $connection = 'mysql2';

    public $table = 'ship_offer';

    protected $primaryKey = '';

    public $fillable = [
       
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
