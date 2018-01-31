<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoOfferExtracted extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'cargo_offer_extracted';

    protected $primaryKey = '';

    public $fillable = [
        "cargo_offer_extracted_ID",
		"emailID",
		"cargo_offerID",
		"cargo",
		"load_place",
		"disch_place",
		"laycan",
		"terms",
		"commission",
		"kibana_extracted",
		"load_place_lat",
		"load_place_lon",
		"disch_place_lat",
		"disch_place_lon",
		"_created_on"
      
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
