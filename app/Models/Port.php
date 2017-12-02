<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Port
 * @package App\Models
 * @version September 10, 2017, 9:42 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection Cargo
 * @property \Illuminate\Database\Eloquent\Collection ShipPosition
 * @property \Illuminate\Database\Eloquent\Collection ships
 * @property string name
 */
class Port extends Model
{
    use SoftDeletes;

    public $table = 'ports';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $geofields = array('location');


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function cargos()
    {
        return $this->hasMany(\App\Models\Cargo::class);
    }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  **/
    // public function cargos()
    // {
    //     return $this->hasMany(\App\Models\Cargo::class);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function shipPositions()
    {
        return $this->hasMany(\App\Models\ShipPosition::class);
    }

    
    //geofield functions 
    public function setLocationAttribute($value) {
        $this->attributes['location'] = DB::raw("POINT($value)");
    }
 
    public function getLocationAttribute($value){
 
        $loc =  substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);
 
        return substr($loc,0,-1);
    }
 
    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach($this->geofields as $column){
            $raw .= ' astext('.$column.') as '.$column.' ';
        }
 
        return parent::newQuery($excludeDeleted)->addSelect('*',DB::raw($raw));
    }

    public function scopeDistance($query,$dist,$location)
    {
        return $query->whereRaw('st_distance(location,POINT('.$location.')) < '.$dist);
 
    }
}
