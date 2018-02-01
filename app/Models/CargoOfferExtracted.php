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

        

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
  //   	"cargo_offer_extracted_ID"=>'string',
		// "emailID"=>'integer',
		// "cargo_offerID"=>'integer',
		// "cargo"=>'string',
		// "load_place"=>'string',
		// "disch_place"=>'string',
		// "laycan"=>'string',
		// "terms"=>'string',
		// "commission"=>'string',
		// "kibana_extracted"=>'string',
		// "disch_place_lat"=>'string',
		// "disch_place_lon"=>'string',
		// "_created_on"=>'date'
    ];

    public $fillable = [
  //       "cargo_offer_extracted_ID",
		// "emailID",
		// "cargo_offerID",
		// "cargo",
		// "load_place",
		// "disch_place",
		// "laycan",
		// "terms",
		// "commission",
		// "kibana_extracted",
		// "load_place_lat",
		// "load_place_lon",
		// "disch_place_lat",
		// "disch_place_lon",
		// "_created_on",
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
