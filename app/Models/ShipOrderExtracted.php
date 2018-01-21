<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOrderExtracted extends Model
{
    //
    protected $connection = 'mysql2';

    public $table = 'ship_order_extracted';

    protected $primaryKey = '';

    public $fillable = [
       
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
