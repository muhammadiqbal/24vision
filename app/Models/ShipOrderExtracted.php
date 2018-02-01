<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOrderExtracted extends Model
{
    //
    protected $connection = 'mysql2';
    public $timestamps = false;

    public $table = 'ship_order_extracted';

    protected $primaryKey = 'ship_order_extracted_ID';

    public $fillable = [
        "ship_order_extracted_ID",
		"ship_size",
		"ship_age",
		"ship_cranes",
		"ship_grabs",
		"ship_type",
		"ship_gear",
		"delivery_location",
		"laycan",
		"employment",
		"cargo",
		"redelivery_location",
		"duration",
		"commission",
		"emailID",
		"ship_order_ID",
		"account_name",
		"kibana_extracted"
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
