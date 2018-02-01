<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOffer extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'ship_offer';

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
        return getConnection()->getSchemaBuilder()->getColumnListing(getTable());
    }
}
