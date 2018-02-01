<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOrder extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'ship_order';

    protected $primaryKey = 'ship_orderID';

    public $fillable = [
        "ship_orderID",
		"accountname",
		"ship_size",
		"age_max",
		"cranes",
		"grabs",
		"ship_type",
		"delivery_location_lat",
		"delivery_location_lon",
		"delivery_port",
		"delivery_time",
		"laycan_begin",
		"laycan_end",
		"duration",
		"redelivery_location_lat",
		"redelivery_location_lon",
		"redelivery_port",
		"redelivery_begin",
		"redelivery_end",
		"description",
		"address_comission",
		"brokerage",
		"companyID"
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
