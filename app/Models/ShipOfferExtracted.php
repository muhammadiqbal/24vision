<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOfferExtracted extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'ship_offer_extracted';

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
