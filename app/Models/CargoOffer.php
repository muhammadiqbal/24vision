<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoOffer extends Model
{
    //
    public $timestamps = false;
    protected $connection = 'mysql2';

    public $table = 'cargo_offer';

    protected $primaryKey = '';

    public $fillable = [
       
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

    public static function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
