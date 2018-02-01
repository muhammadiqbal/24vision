<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoOffer extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'cargo_offer';

    protected $primaryKey = ' cargo_offerID';

    public $fillable = [
        "cargo_offerID",
        "quantity",
        "accountname",
        "quantity_lower",
        "quantity_upper",
        "cargo_typeID",
        "load_port_ID",
        "load_region",
        "destination_port_ID",
        "destination_region",
        "laycan_begin",
        "laycan_end",
        "rate_loading",
        "rate_loading_days",
        "rate_unloading",
        "rate_unloading_days",
        "commission_address",
        "commission_brokerage",
        "ownerID"
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
       
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
