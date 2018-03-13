<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Calculator;

/**
 * Class Cargo
 * @package App\Models
 * @version January 10, 2018, 9:27 am UTC
 *
 * @property \App\Models\CargoType cargoType
 * @property \App\Models\Port port
 * @property \App\Models\LoadingDischargingRateType loadingDischargingRateType
 * @property \App\Models\Port port
 * @property \App\Models\LoadingDischargingRateType loadingDischargingRateType
 * @property \App\Models\QuantityMeasurement quantityMeasurement
 * @property \App\Models\StowageFactorUnit stowageFactorUnit
 * @property \App\Models\ShipSpecialization shipSpecialization
 * @property \App\Models\CargoStatus cargoStatus
 * @property \Illuminate\Database\Eloquent\Collection distances
 * @property integer loading_port
 * @property boolean loading_port_manual
 * @property integer discharging_port
 * @property boolean discharging_port_manual
 * @property date laycan_first_day
 * @property boolean laycan_first_day_manual
 * @property boolean laycan_first_day_constructed
 * @property date laycan_last_day
 * @property boolean laycan_last_day_manual
 * @property boolean laycan_last_day_constructed
 * @property integer cargo_type_id
 * @property boolean cargo_type_id_manual
 * @property decimal stowage_factor
 * @property boolean stowage_factor_manual
 * @property boolean stowage_factor_constructed
 * @property integer sf_unit
 * @property integer ship_specialization_id
 * @property integer quantity_measurement_id
 * @property integer quantity
 * @property boolean quantity_manual
 * @property boolean quantity_constructed
 * @property integer loading_rate_type
 * @property boolean loading_rate_type_manual
 * @property integer loading_rate
 * @property boolean loading_rate_manual
 * @property boolean loading_rate_constructed
 * @property integer discharging_rate_type
 * @property boolean discharging_rate_type_manual
 * @property integer discharging_rate
 * @property boolean discharging_rate_manual
 * @property boolean discharging_rate_constructed
 * @property string extra_condition
 * @property decimal commission
 * @property boolean commision_manual
 * @property boolean commision_constructed
 * @property integer email_id
 * @property integer status_id
 */
class Cargo extends Model
{
    

    use SoftDeletes;

    public $table = 'cargos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    /*START non db attributes */
    public $ntce;
    public $grossRate;
    public $route;
    public $bdi;
    /*END non db attributes*/

    public $fillable = [
        'loading_port',
        'loading_port_manual',
        'discharging_port',
        'discharging_port_manual',
        'laycan_first_day',
        'laycan_first_day_manual',
        'laycan_first_day_constructed',
        'laycan_last_day',
        'laycan_last_day_manual',
        'laycan_last_day_constructed',
        'cargo_type_id',
        'cargo_type_id_manual',
        'stowage_factor',
        'stowage_factor_manual',
        'stowage_factor_constructed',
        'sf_unit',
        'ship_specialization_id',
        'quantity_measurement_id',
        'quantity',
        'quantity_manual',
        'quantity_constructed',
        'loading_rate_type',
        'loading_rate_type_manual',
        'loading_rate',
        'loading_rate_manual',
        'loading_rate_constructed',
        'discharging_rate_type',
        'discharging_rate_type_manual',
        'discharging_rate',
        'discharging_rate_manual',
        'discharging_rate_constructed',
        'extra_condition',
        'commission',
        'commision_manual',
        'commision_constructed',
        'email_id',
        'status_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'loading_port' => 'integer',
        'loading_port_manual' => 'boolean',
        'discharging_port' => 'integer',
        'discharging_port_manual' => 'boolean',
        'laycan_first_day' => 'date',
        'laycan_first_day_manual' => 'boolean',
        'laycan_first_day_constructed' => 'boolean',
        'laycan_last_day' => 'date',
        'laycan_last_day_manual' => 'boolean',
        'laycan_last_day_constructed' => 'boolean',
        'cargo_type_id' => 'integer',
        'cargo_type_id_manual' => 'boolean',
        'stowage_factor_manual' => 'boolean',
        'stowage_factor_constructed' => 'boolean',
        'sf_unit' => 'integer',
        'ship_specialization_id' => 'integer',
        'quantity_measurement_id' => 'integer',
        'quantity' => 'integer',
        'quantity_manual' => 'boolean',
        'quantity_constructed' => 'boolean',
        'loading_rate_type' => 'integer',
        'loading_rate_type_manual' => 'boolean',
        'loading_rate' => 'integer',
        'loading_rate_manual' => 'boolean',
        'loading_rate_constructed' => 'boolean',
        'discharging_rate_type' => 'integer',
        'discharging_rate_type_manual' => 'boolean',
        'discharging_rate' => 'integer',
        'discharging_rate_manual' => 'boolean',
        'discharging_rate_constructed' => 'boolean',
        'extra_condition' => 'string',
        'commision_manual' => 'boolean',
        'commision_constructed' => 'boolean',
        'email_id' => 'integer',
        'status_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'laycan_first_day'=>'nullable|date',
        'laycan_last_day'=>'nullable|date|after_or_equal:laycan_first_day'
    ];

 

    /*START non db attribute setter and getter*/
    public function setNtce($port, $ship, $date_of_opening){
        $ship_bdi = Ship::find('1'); // Reference Ship for calculating tje GrossRate
        $date_of_opening = new \Carbon\Carbon($date_of_opening);
        $distance_to_start = $this->calculateDistancetoStart($port, $this);
        $distance_cargo =  $this->calculateDistancetoCargo($this);
        $distance_sum = $this->calculateDistanceSum($distance_to_start, $distance_cargo);
        $travel_time_to_start = $this->calculateTravelTimeToStart($ship, $distance_to_start);
        $travel_time_cargo =  $this->calculateTravelTimeCargo($ship, $distance_cargo);
        $travel_time_sum = $this->calculateTravelTimeSum($travel_time_to_start, $travel_time_cargo);
        $port_time_load = $this->calculatePortTimeLoad($this);
        $port_time_disch = $this->calculatePortTimeDisch($this);
        $port_time_sum = $this->calculatePortTimeSum($port_time_load, $port_time_disch);
        $voyage_time = $this->calculateVoyageTime($port_time_sum, $travel_time_sum);
        
        $travel_time_to_start_bdi = $this->calculateTravelTimeToStart($ship_bdi, $distance_to_start);
        $travel_time_cargo_bdi =  $this->calculateTravelTimeCargo($ship_bdi, $distance_cargo);
        $travel_time_sum_bdi = $this->calculateTravelTimeSum($travel_time_to_start_bdi, $travel_time_cargo_bdi);      
        $voyage_time_bdi = $this->calculateVoyageTime($port_time_sum, $travel_time_sum_bdi);  
        
        
        $fuel_consumption = $this->calculateFuelConsumption($ship, $port_time_sum, $travel_time_sum);
        $fuel_price =  $this->calculateFuelPrice($ship, $date_of_opening, $travel_time_to_start);
        $fuel_costs =  $this->calculateFuelCosts($fuel_price,$fuel_consumption);
        $port_fee_load = $this->calculatePortFeeLoad($this, $date_of_opening, $travel_time_to_start);
        //$port_fee_load = 10000;
        $port_fee_disch = $this->calculatePortFeeDisch($this, $date_of_opening, $voyage_time, $port_time_disch);
        $non_hire_costs =  $this->calculateNonHireCosts($fuel_costs, $port_fee_load, $port_fee_disch);
        
        $fuel_consumption_bdi = $this->calculateFuelConsumption($ship_bdi, $port_time_sum, $travel_time_sum_bdi);
        $fuel_price_bdi =  $this->calculateFuelPrice($ship_bdi, $date_of_opening, $travel_time_to_start_bdi);
        $fuel_costs_bdi =  $this->calculateFuelCosts($fuel_price_bdi,$fuel_consumption_bdi);
        $port_fee_load_bdi = $this->calculatePortFeeLoad($this, $date_of_opening, $travel_time_to_start_bdi);
        //$port_fee_load_bdi = 10000;
        $port_fee_disch_bdi = $this->calculatePortFeeDisch($this, $date_of_opening, $voyage_time_bdi, $port_time_disch);
        $non_hire_costs_bdi =  $this->calculateNonHireCosts($fuel_costs_bdi, $port_fee_load_bdi, $port_fee_disch_bdi);
        
        $bdi_id = $this->calculateBDIId($port,$this);
        $bdi = $this->calculateBDI($bdi_id, $date_of_opening, $travel_time_to_start);
        $gross_rate = $this->calculateGrossRate($this, $bdi, $voyage_time_bdi, $non_hire_costs_bdi);
        $ntce = $this->calculateNTCE($this, $bdi, $voyage_time, $non_hire_costs, $gross_rate);
        return $ntce;
    }

    public function getNtce(){
        return $this->ntce;
    }

    public function setGrossRate($port, $ship, $date_of_opening){
        $ship_bdi = Ship::find('1'); // Reference Ship for calculating tje GrossRate
        $date_of_opening = new \Carbon\Carbon($date_of_opening);
        $distance_to_start = $this->calculateDistancetoStart($port, $this);
        $distance_cargo =  $this->calculateDistancetoCargo($this);
        $distance_sum = $this->calculateDistanceSum($distance_to_start, $distance_cargo);
        $travel_time_to_start = $this->calculateTravelTimeToStart($ship, $distance_to_start);
        $travel_time_cargo =  $this->calculateTravelTimeCargo($ship, $distance_cargo);
        $travel_time_sum = $this->calculateTravelTimeSum($travel_time_to_start, $travel_time_cargo);
        $port_time_load = $this->calculatePortTimeLoad($this);
        $port_time_disch = $this->calculatePortTimeDisch($this);
        $port_time_sum = $this->calculatePortTimeSum($port_time_load, $port_time_disch);
        $voyage_time = $this->calculateVoyageTime($port_time_sum, $travel_time_sum);
        
        $travel_time_to_start_bdi = $this->calculateTravelTimeToStart($ship_bdi, $distance_to_start);
        $travel_time_cargo_bdi =  $this->calculateTravelTimeCargo($ship_bdi, $distance_cargo);
        $travel_time_sum_bdi = $this->calculateTravelTimeSum($travel_time_to_start_bdi, $travel_time_cargo_bdi);      
        $voyage_time_bdi = $this->calculateVoyageTime($port_time_sum, $travel_time_sum_bdi);  
        
        
        $fuel_consumption = $this->calculateFuelConsumption($ship, $port_time_sum, $travel_time_sum);
        $fuel_price =  $this->calculateFuelPrice($ship, $date_of_opening, $travel_time_to_start);
        $fuel_costs =  $this->calculateFuelCosts($fuel_price,$fuel_consumption);
        $port_fee_load = $this->calculatePortFeeLoad($this, $date_of_opening, $travel_time_to_start);
        //$port_fee_load = 10000;
        $port_fee_disch = $this->calculatePortFeeDisch($this, $date_of_opening, $voyage_time, $port_time_disch);
        $non_hire_costs =  $this->calculateNonHireCosts($fuel_costs, $port_fee_load, $port_fee_disch);
        
        $fuel_consumption_bdi = $this->calculateFuelConsumption($ship_bdi, $port_time_sum, $travel_time_sum_bdi);
        $fuel_price_bdi =  $this->calculateFuelPrice($ship_bdi, $date_of_opening, $travel_time_to_start_bdi);
        $fuel_costs_bdi =  $this->calculateFuelCosts($fuel_price_bdi,$fuel_consumption_bdi);
        $port_fee_load_bdi = $this->calculatePortFeeLoad($this, $date_of_opening, $travel_time_to_start_bdi);
        //$port_fee_load_bdi = 10000;
        $port_fee_disch_bdi = $this->calculatePortFeeDisch($this, $date_of_opening, $voyage_time_bdi, $port_time_disch);
        $non_hire_costs_bdi =  $this->calculateNonHireCosts($fuel_costs_bdi, $port_fee_load_bdi, $port_fee_disch_bdi);
        
        $bdi_id = $this->calculateBDIId($port,$this);
        $bdi = $this->calculateBDI($bdi_id, $date_of_opening, $travel_time_to_start);
        $gross_rate = $this->calculateGrossRate($this, $bdi, $voyage_time_bdi, $non_hire_costs_bdi);
        return $gross_rate;
    }

    public function getGrossRate(){
        return $this->grossRate;
    }

    public function setRoute(Route $route){
        $this->route = $route;
    }

    public function getRoute(){
        return $this->route;
    }

    public function setBdi(Port $port,Ship $ship, $date_of_opening){
        $distance_to_start = $this->calculateDistancetoStart($port, $this);
        $travel_time_to_start = $this->calculateTravelTimeToStart($ship, $distance_to_start);
        $bdi_id = $this->calculateBDIId($port,$this);
        $this->bdi = $this->calculateBDI($bdi_id, $date_of_opening, $travel_time_to_start);
        return $this->bdi;
    }

    public function getBdi(){
        return $this->bdi;
    }
    /*END non db attribute setter and getter*/


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cargoType()
    {
        return $this->belongsTo(\App\Models\CargoType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function loadingPort()
    {
        return $this->belongsTo(\App\Models\Port::class,'loading_port');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function dischargingPort()
    {
        return $this->belongsTo(\App\Models\Port::class,'discharging_port');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function loadingDischargingRateType()
    {
        return $this->belongsTo(\App\Models\LoadingDischargingRateType::class);
    }

    // /**
     // * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     // **/
    // public function loadingDischargingRateType()
    // {
        // return $this->belongsTo(\App\Models\LoadingDischargingRateType::class);
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function quantityMeasurement()
    {
        return $this->belongsTo(\App\Models\QuantityMeasurement::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function stowageFactorUnit()
    {
        return $this->belongsTo(\App\Models\StowageFactorUnit::class,'sf_unit');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shipSpecialization()
    {
        return $this->belongsTo(\App\Models\ShipSpecialization::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cargoStatus()
    {
        return $this->belongsTo(\App\Models\CargoStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function email()
    {
        return $this->belongsTo(\App\Models\Email::class,'email_id');
    }





         //Format laycan_last_day for visualization and manage missing date
    function formatLaycanFirst(Cargo $cargo){
        if($cargo->laycan_first_day != null){ 
        $laycan_first_day= $cargo->laycan_first_day->format('m/d/Y');
        } 
        else{
        $laycan_first_day= null;
        }
        
        return $laycan_first_day;   
    }
    
    //Format laycan_last_day for visualization and manage missing date
    function formatLaycanLast(Cargo $cargo){
        if($cargo->laycan_last_day != null){ 
        $laycan_last_day= $cargo->laycan_last_day->format('m/d/Y');
        } 
        else{
        $laycan_last_day= null;
        }
        
        return $laycan_last_day;    
    }
    

    //Formular for finding Stowage an return attributes as array
    public function findStowage(Cargo $cargo){
        
        
        $stowage_factor = $cargo->stowage_factor;
        $stowage_factor_unit = $cargo->sf_unit;
        
        //Takes stowage factor from cargo type , if none is given by cargo entry
        if ($stowage_factor==null OR $stowage_factor_unit==null ) {
            $cargo_type_id = $cargo->cargo_type_id;
            // NULL handling (for attributes coming from cargo or calculated based on it)
            if ($cargo_type_id==null ) {
                $stowage_factor = null;
                $stowage_factor_unit = null;
                
                $stowage = array ($stowage_factor,$stowage_factor_unit);
                return $stowage;
            }else{
                $cargo_type = CargoType::find($cargo_type_id);  
                $stowage_factor = $cargo_type->stowage_factor;
                $stowage_factor_unit = $cargo_type->sf_unit;
            }           
        }
        // Receive parameters from objects
        
        $stowage_factor_unit_name = StowageFactorUnit::find($stowage_factor_unit)->unit;
        
        $stowage = array ($stowage_factor,$stowage_factor_unit_name);
        
        return $stowage;
    }       
    
    
        //Formular for calculating direct distance between two points with given latidude and longitude
        // Based on: https://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php 
    public function calculateDistance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $nm = 0.868976 * $miles;
        return $nm;
    }
    
    //Formular for calculating (and storing) the Distance to start, used for calculating TravelTimeToStart
    public function calculateDistancetoStart(Port $port_ship, Cargo $cargo){
        
        
        // Receive parameters from objects
        $port_ship_id =  $port_ship->id;
        $port_start_id = $cargo->loading_port;
        
        // NULL handling (for attributes coming from cargo or calculated based on it)
        if($port_start_id ==null){
            $distance_to_start = null;
            return $distance_to_start;
        }
        // Formular for result of the function
        $distance = Distance::where('start_port',$port_ship_id)->where('end_port',$port_start_id)->get();


        // If not DB entry exist yet, calculate distance and store it in the database (2 entries: 2nd witch switched port positions)
        if ($distance->isEmpty()) {
                        
            $lat1 = Port::find($port_ship_id)->latitude;
            $lon1 = Port::find($port_ship_id)->longitude;
            $lat2 = Port::find($port_start_id)->latitude;
            $lon2 = Port::find($port_start_id)->longitude;
    
            $distance_to_start = $this->calculateDistance($lat1, $lon1, $lat2, $lon2);
            
//          "XXX Insert the new calculated distances into the table 'distances', create 2 entries, the second withs witched ports XXX";

        }
        else {
            $distance_to_start = $distance[0]->distance;
        }

        return $distance_to_start;
    }

    //Formular for calculating the Distance for cargo, used for calculating TravelTimeCargo
    public function calculateDistancetoCargo(Cargo $cargo){
        
        // Receive parameters from objects
        $port_start_id = $cargo->loading_port;
        $port_end_id = $cargo->discharging_port;
        
        // NULL handling (for attributes coming from cargo or calculated based on it)
        if($port_start_id ==null OR $port_end_id ==null){
            $distance_cargo = null;
            return $distance_cargo;
        }
        
        // Formular for result of the function
        $distance = Distance::where('start_port',$port_start_id)->where('end_port',$port_end_id)->get();


        // If not DB entry exist yet, calculate distance and store it in the database (2 entries: 2nd witch switched port positions)
        if ($distance->isEmpty()) {
            
            $lat1 = Port::find($port_start_id)->latitude;
            $lon1 = Port::find($port_start_id)->longitude;
            $lat2 = Port::find($port_end_id)->latitude;
            $lon2 = Port::find($port_end_id)->longitude;
    
            $distance_cargo = $this->calculateDistance($lat1, $lon1, $lat2, $lon2);
            
//          "XXX Insert the new calculated distances into the table 'distances', create 2 entries, the second withs witched ports XXX";

        }else {
            $distance_cargo = $distance[0]->distance;
        }

        return $distance_cargo;
    }
    
    //Formular for calculating the overall distance
    public function calculateDistanceSum($distance_to_start, $distance_cargo){
        
        // Formular for result of the function
        $distance__sum = $distance_to_start + $distance_cargo;

        return $distance__sum;
    }   
    
    
    //Formular for calculating the Travel Time to start, used for calculating TravelTimeSum and extracting FuelPrice, BDI and PortFeeLoad
    public function calculateTravelTimeToStart(Ship $ship, $distance_to_start){
        
        // Receive parameters from objects
        $speed_ballast = $ship->speed_ballast;
        
        // Formular for result of the function
        $travel_time_to_start= $distance_to_start/$speed_ballast/(24*0.95);

        return $travel_time_to_start;

    }

        //Formular for calculating the Travel Time for cargo, used for calculating TravelTimeSum 
    public function calculateTravelTimeCargo(Ship $ship, $distance_cargo){
        
        // Receive parameters from objects
        $speed_laden = $ship->speed_laden;
        
        // Formular for result of the function
        $travel_time_cargo= $distance_cargo/$speed_laden/(24*0.95);

        return $travel_time_cargo;
    }
    

    
    //Formular for calculating the overall Travel Time, used for calculating VoyageTime and FuelConsumption 
    public function calculateTravelTimeSum($travel_time_to_start, $travel_time_cargo){
        
        // Formular for result of the function
        $travel_time_sum= $travel_time_to_start + $travel_time_cargo;

        return $travel_time_sum;
    }

    //Formular for calculating the Port Time for Loading, used for calculating PortTimeSum
    public function calculatePortTimeLoad(Cargo $cargo){
        // Receive parameters from objects  
        $quantity = $cargo->quantity;
        $load_speed = $cargo->loading_rate;
        $loading_rate_type = $cargo->loading_rate_type;
        
        
        // NULL handling (for attributes coming from cargo or calculated based on it)
        if($quantity ==null OR $load_speed ==null){
            $port_time_load = null;
            return $port_time_load;
        }
        if($loading_rate_type==null){
            $load_factor = 1;
        } else {
            
            // Determine loadinf factor of loading rate type
            $load_factor = LdRateType::find($loading_rate_type)->rate_type_factor;  
        }
        
        
        
        
        // Formular for result of the function
        //+1 because there is one day extra for each port
        $port_time_load = $quantity/$load_speed*$load_factor +1;

        return $port_time_load;
    }   

    
    //Formular for calculating the Port Time for Discharging, used for calculating PortTimeSum and extracting PortFeeDisch
    public function calculatePortTimeDisch(Cargo $cargo){
        // Receive parameters from objects  
        $quantity = $cargo->quantity;
        $disch_speed = $cargo->discharging_rate;
        $discharging_rate_type = $cargo->discharging_rate_type;
        
        // NULL handling (for attributes coming from cargo or calculated based on it)
        if($quantity ==null OR $disch_speed ==null){
            $port_time_disch = null;
            return $port_time_disch;
        }
        if($discharging_rate_type==null){
            $disch_factor = 1;
        } else {
            
            // Determine loadinf factor of loading rate type
            $disch_factor  = LdRateType::find($discharging_rate_type)->rate_type_factor;    
        }
            
        
        // Formular for result of the function
        //+1 because there is one day extra for each port
        $port_time_disch = $quantity/$disch_speed*$disch_factor+1;

        return $port_time_disch;
    }   
    
    //Formular for calculating the overall Port Time, used for calculating VoyageTime and FuelConsumption 
    public function calculatePortTimeSum($port_time_load, $port_time_disch){
        
        // Formular for result of the function
        $port_time_sum= $port_time_load + $port_time_disch;

        return $port_time_sum;
    }



    
    //Formular for calculating the Voyagage Time, used for calculation GroosRate, NTCE and extract PortFeeDisch
    public function calculateVoyageTime($port_time_sum, $travel_time_sum){
        // Formular for result of the function
        $voyage_time = $port_time_sum + $travel_time_sum;

        return $voyage_time;
    }

    
    //Formular for calculating Fuel Consumption, used for Fuel Costs
    public function calculateFuelConsumption(Ship $ship, $port_time_sum, $travel_time_sum){

        // Receive parameters from objects
        $fuel_consumption_port = $ship->fuel_consumption_in_port;
        $fuel_consumption_travel = $ship->fuel_consumption_at_sea;
        
        // Formular for result of the function

        $fuel_consumption = $port_time_sum*$fuel_consumption_port + $travel_time_sum*$fuel_consumption_travel;

        return $fuel_consumption;
    }
    
    //Formular for extract Fuel Price from table "fuel_prices", used for calculating Fuel Costs 
    public function calculateFuelPrice(Ship $ship, $date, $travel_time_to_start){

        // Receive parameters from objects
        $fuel_type_id = $ship->fuel_type_id;
        $date_price = $date->copy()->addDays('10'); // The date when the ship arrives the start port is relevant
        
        // Formular for result of the function
        
        // No price entry has an enddate older than the date_price -> use the latest entry with end date null
        if ($fuel_price_entry = FuelPrice::where('end_date','>=',$date_price)->get()->isEmpty()) {
            $fuel_price_entry = FuelPrice::where('end_date',null)->where('fuel_type_id',$fuel_type_id)->get();
        }
        // price entries with an enddate older than the date_price found -> apply other filters
        else {
            $fuel_price_entry = FuelPrice::where('end_date','>=',$date_price)->where('start_date','<=',$date_price)->where('fuel_type_id',$fuel_type_id)->get();
        }
        
        $fuel_price = $fuel_price_entry[0]->price; 

        return $fuel_price;
    }

    //Formular for calculating the Fuel Costs, used for calculating  the Non HireCosts
    public function calculateFuelCosts($fuel_price,$fuel_consumption)
    {
    
        // Formular for result of the function
        $fuel_costs = $fuel_price*$fuel_consumption;

        return $fuel_costs;
    }   

    
    //Formular for extract Port Fee for Loading  from table "Fee_prices", used for calculating NonHireCosts  
    public function calculatePortFeeLoad(Cargo $cargo, $date, $travel_time_to_start){

        // Receive parameters from objects
        $port_start_id = $cargo->loading_port;
        $date_price = $date->copy()->addDays($travel_time_to_start);  // The date when the ship arrives the start port is relevant
        
        // NULL handling (for attributes coming from cargo or calculated based on it)
        if($port_start_id ==null){
            $port_fee_load = null;
            return $port_fee_load;
        }
        
        // Formular for result of the function
        
        // No price entry has an enddate older than the date_price -> use the latest entry with end date null
        if ($fee_price_entry = FeePrice::where('end_date','>=',$date_price)->get()->isEmpty()) {

            $fee_price_entry = FeePrice::where('end_date',null)->where('port_id',$port_start_id)->first();
        }
        // price entries with an enddate older than the date_price found -> apply other filters
        else {
            
            $fee_price_entry = FeePrice::where('end_date','>=',$date_price)->where('start_date','<=',$date_price)->where('port_id',$port_start_id)->first();
        }
        if ($fee_price_entry) {
            return $fee_price_entry->price; 
        }
        else{
            return 0;
        }
    }

    //Formular for extract Port Fee for Discharging from table "Fee_prices", used for calculating NonHireCosts 
    public function calculatePortFeeDisch(Cargo $cargo, $date, $voyage_time, $port_time_disch){

        // Receive parameters from objects
        $port_end_id = $cargo->discharging_port;
        $days = $voyage_time - $port_time_disch;
        $date_price = $date->copy()->addDays($days); // The date when the ship arrives the end port is relevant
        
        // Formular for result of the function
        // NULL handling (for attributes coming from cargo or calculated based on it)
        if($port_end_id == null){
            $port_fee_disch = null;
            return $port_fee_disch;
        }

        // No price entry has an enddate older than the date_price -> use the latest entry with end date null
        

        if ($fee_price_entry = FeePrice::where('end_date','>', $date_price)->get()->isEmpty()) {
            $fee_price_entry = FeePrice::where('end_date',null)->where('port_id',$port_end_id)->get();
        }
        // price entries with an enddate older than the date_price found -> apply other filters
        else {
            
            $fee_price_entry = FeePrice::where('end_date','>=',$date_price)->where('start_date','<=',$date_price)->where('port_id',$port_end_id)->get();
        }


        $port_fee_disch = $fee_price_entry[0]->price; 
 
        
        return $port_fee_disch;
    }
    

    
    
    //Formular for calculating the NonHireCosts, used for calculating Grossrate and NTCE 
    public function calculateNonHireCosts($fuel_costs, $port_fee_load, $port_fee_disch)
    {
    
        // Formular for result of the function
        $non_hire_costs = $port_fee_load + $port_fee_disch + $fuel_costs;

        return $non_hire_costs;
    }   

    
    //Formular for extract BDI ID from table "paths", used for calculating BDI Price 
    public function calculateBDIId(Port $port_ship, Cargo $cargo){

    
        $port_ship_zone =  $port_ship->zone_id;
        $port_start_id = $cargo->loading_port;
        $port_end_id = $cargo->discharging_port;
        
        // NULL handling (for attributes coming from cargo or calculated based on it)
        if($port_start_id ==null OR $port_end_id == null){
            $bdi_id = null;
            return $bdi_id;
        }
        
        $port_start_zone = Port::find($port_start_id)->zone_id;
        $port_end_zone = Port::find($port_end_id)->zone_id;
        // Find the right bdi_id
        // Step 1:  find matching path
        if ($port_ship_zone == $port_start_zone OR $port_start_zone == $port_end_zone ) {
            $paths = Path::where('zone1',$port_ship_zone)->where('zone2',null)->where('zone3',$port_end_zone)->get();

        } else {
            $paths = Path::where('zone1',$port_ship_zone)->where('zone2',$port_start_zone)->where('zone3',$port_end_zone)->get();
        }
        
        // Step 1b: If no path is found, return route_id =0
        if ($paths->isEmpty()){
            $bdi_id = '540666';
        } else {
        // Step 2: determine bdi_id for route
        $route_id = $paths[0]->route_id;
        $bdi_id = Routes::find($route_id)->bdi_id;
        }
        
        return $bdi_id;
    }       
    
    
    //Formular for extract BDI Price from table "bdi_prices", used for calculating Grossrate and NTCE 
    public function calculateBDI($bdi_id, $date, $travel_time_to_start){

        $date = new \Carbon\Carbon($date);
        // Receive parameters from objects
        $date_price = $date->addDays($travel_time_to_start); // The date when the ship arrives the start port is relevant
        
        // NULL handling (for attributes coming from cargo or calculated based on it)
        if($bdi_id ==null){
            $bdi = null;
            return $bdi ;
        }
        
        // Formular for result of the function


        // No price entry has an enddate older than the date_price -> use the latest entry with end date null
        if (BdiPrice::where('end_date','>=',$date_price)->get()->isEmpty()) {
            $bdi_entry = BdiPrice::where('end_date',null)->where('bdi_id',$bdi_id)->get();
        }
        // price entries with an enddate older than the date_price found -> apply other filters
        else {
            $bdi_entry = BdiPrice::where('end_date','>=',$date_price)->where('start_date','<=',$date_price)->where('bdi_id',$bdi_id)->get();
        }
        $bdi = $bdi_entry[0]->price; 
        
        
        return $bdi;
    }   
    
    
    //Formular for calculating the Grossrate, used for calculateNTCE 
    public function calculateGrossRate(Cargo $cargo, $bdi, $voyage_time, $non_hire_costs){
        // Receive parameter from objects
        $voy_comm = $cargo->comission/100;
        $quantity = $cargo->quantity;
        
        // NULL handling (for attributes coming from cargo or calculated based on it) <-- voy_comm may be null, calculation is still possible
        if($quantity == null){  
            $gross_rate = null;
            return $gross_rate ;
        }
        
        // Formular for result of the function
        $gross_rate= ( $bdi * $voyage_time + $non_hire_costs) / ((1 - $voy_comm) * $quantity);

     return $gross_rate;
   }

   //Formular for calculating the NTCE, used as final result 
    public function calculateNTCE(Cargo $cargo, $bdi, $voyage_time, $non_hire_costs, $rate){
        
        
        // Receive parameter from objects
        $voy_comm = $cargo->comission/100;
        $quantity = $cargo->quantity;
        
        // NULL handling (for attributes coming from cargo or calculated based on it) <-- voy_comm may be null, calculation is still possible
        if($quantity == null OR $voyage_time == null){  
            $ntce = null;
            return $ntce ;
        }
        
        // Formular for result of the function
        $ntce= (((1 - $voy_comm) * $quantity * $rate) - $non_hire_costs ) / $voyage_time;

        return $ntce;
    } 
}
