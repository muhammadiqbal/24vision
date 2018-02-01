<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOffer extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'ship_offer';

    protected $primaryKey = 'ship_offerID';

    public $fillable = [
        "ship_offerID",
		"shipID",
		"availability_time",
		"availability_location_lat",
		"avilability_location_lon",
		"availability_port_ID",
		"ownerID",
		"owner_preferences",
		"bunker_desc"
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
