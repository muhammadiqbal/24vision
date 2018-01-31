<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOrder extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'ship_order';

    protected $primaryKey = '';

    public $fillable = [
       
    ];

           /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
