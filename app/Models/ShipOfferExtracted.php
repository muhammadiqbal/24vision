<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipOfferExtracted extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'ship_offer_extracted';

    protected $primaryKey = 'ship_offer_extracted_ID';

    public $fillable = [
        "ship_offer_extracted_ID",
		"emailID",
		"ship_offer_ID",
		"ship_name",
		"ship_year",
		"ship_dwt",
		"loading_place",
		"open_date",
		"destination",
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
