<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoOffer extends Model
{
    //
    protected $connection = 'mysql2';

    public $table = 'cargo_offer';

    protected $primaryKey = '';

    public $fillable = [
       
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
