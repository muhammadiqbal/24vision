<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOrderExtracted extends Model
{
    //
    protected $connection = 'mysql2';
    public $timestamps = false;

    public $table = 'ship_order_extracted';

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

    public static function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
