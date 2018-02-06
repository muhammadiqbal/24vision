<?php
namespace App\Services;
use Carbon\Carbon;
use App\Models\ShipPosition;
use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Ship;
use App\Models\Region;
use App\Models\Distance;
use App\Models\Port;
use App\Models\Bdi;
use App\Models\LdRateType;
use App\Models\FuelPrice;   
use App\Models\FeePrice;
use App\Models\BdiPrice;
use App\Models\Path;
use App\Models\FuelType;
use App\Models\FuelConsumption;
use App\Models\CargoType;
use App\Models\StowageFactorUnit;

class Calculator
{

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
	protected function calculateDistance($lat1, $lon1, $lat2, $lon2) {

		$theta = $lon1 - $lon2;
  		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  		$dist = acos($dist);
  		$dist = rad2deg($dist);
  		$miles = $dist * 60 * 1.1515;
		$nm = 0.868976 * $miles;
		return $nm;
	}
	
    //Formular for calculating (and storing) the Distance to start, used for calculating TravelTimeToStart
	public function calculateDistancetoStart(Port $port_ship, Cargo $cargo, Calculator $calculator){
		
		
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
	
			$distance_to_start = $calculator->calculateDistance($lat1, $lon1, $lat2, $lon2);
			
//			"XXX Insert the new calculated distances into the table 'distances', create 2 entries, the second withs witched ports XXX";

		}
		else {
			$distance_to_start = $distance[0]->distance;
		}

        return $distance_to_start;
    }

	//Formular for calculating the Distance for cargo, used for calculating TravelTimeCargo
	public function calculateDistancetoCargo(Cargo $cargo, Calculator $calculator){
		
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
	
			$distance_cargo = $calculator->calculateDistance($lat1, $lon1, $lat2, $lon2);
			
//			"XXX Insert the new calculated distances into the table 'distances', create 2 entries, the second withs witched ports XXX";

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
	public function calculateFuelConsumption(Cargo $cargo, $ship_id, $fuel_type ,  $travel_time_to_start, $travel_time_cargo, $port_time_load, $port_time_disch){
		
		// Receive parameters from objects 
		$fuel_consumption = FuelConsumption::where('ship_id',$ship_id,)->where('fuel_type_id',$fuel_type)->get();
		
		$fuel_consumption_sea_ballast_factor= $fuel_consumption->fuel_consumption_sea_ballast;
		$fuel_consumption_sea_laden_factor = $fuel_consumption->fuel_consumption_sea_laden;
		$fuel_consumption_port_idle_factor = $fuel_consumption->fuel_consumption_port_idle;
		$fuel_consumption_port_working_factor = $fuel_consumption->fuel_consumption_port_working;
		
		$discharging_rate_type = $cargo->discharging_rate_type;
		$loading_rate_type = $cargo->loading_rate_type;	
		
		
		// NULL handling (for attributes coming from cargo or calculated based on it)
		if($discharging_rate_type==null){
			$disch_factor = 1;
		} else {
			// Determine loadinf factor of loading rate type
			$disch_factor  = LdRateType::find($discharging_rate_type)->rate_type_factor;	
		}
			
		if($loading_rate_type==null){
			$load_factor = 1;
		} else {
			
			// Determine loadinf factor of loading rate type
			$load_factor = LdRateType::find($loading_rate_type)->rate_type_factor;	
		}
		
		// Calculate  additional parameters 	
		$port_time_idle = 2 + $port_time_load * (1 - 1/$load_factor) + $port_time_disch * (1- 1/$disch_factor);
		$port_time_working = $port_time_load + $port_time_disch - $port_time_idle;
		
		
		// Formular for result of the function
		$fuel_consumption_sea_ballast= $fuel_consumption_sea_ballast*$travel_time_to_start;
		$fuel_consumption_sea_laden = $fuel_consumption_sea_laden*$travel_time_cargo;
		$fuel_consumption_port_idle = $fuel_consumption_port_idle*$port_time_idle;
		$fuel_consumption_port_working = $fuel_consumption_port_working*$port_time_working;
		
		
		$fuel_consumption = $fuel_consumption_sea_ballast + $fuel_consumption_sea_laden + $fuel_consumption_port_idle + $fuel_consumption_port_working;

        return $fuel_consumption;
    }
	
	//Formular for extract Fuel Price from table "fuel_prices", used for calculating Fuel Costs 
	public function calculateFuelPrice($fuel_type_id, $date, $travel_time_to_start){

		// Receive parameters from objects
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
	
	 public function createFuelArray(Cargo $cargo, Ship $ship, $date, $travel_time_to_start, $travel_time_cargo, $port_time_load, $port_time_disch) {
		
		$ship_id = $ship->ship_id;
		$fuel_types_array = FuelConsumption::where('ship_id',id)->get();
		$length = count($fuel_types_array);
		
		$fuel_array = [];
		
		for ($i = 0; $i < $length; ++$i) {
		
			$fuel_type_id = $fuel_types_array[$i]->fuel_type_id;
			
			$fuel_consumption = calculateFuelConsumption(Cargo $cargo, $ship_id, $fuel_type_id, $travel_time_to_start, $travel_time_cargo, $port_time_load, $port_time_disch);
			$fuel_price = calculateFuelPrice($fuel_type_id, $date, $travel_time_to_start);
			$fuel_costs = calculateFuelCosts($fuel_consumption, $fuel_price);
			
			$fuel_array_entry = array('fuel_consumption' => $fuel_consumption, 'fuel_price' => $fuel_price, 'fuel_costs' => $fuel_costs);
			$fuel_array[] = $fuel_array_entry;
		}
		
        return $fuel_array;
    }
	
	
    public function calculateTotalFuelCosts(($fuel_array ){

		$total_fuel_costs = 0.00;
		
		foreach ($fuel_array as $fuel_array_entry) {
			$fuel_costs=$fuel_array_entry['fuel_costs'];
			$total_fuel_costs = $total_fuel_costs + $fuel_costs;
		}
		
		// Formular for result of the function
		$fuel_costs = $fuel_price*$fuel_consumption;

        return $total_fuel_costs;
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

			$fee_price_entry = FeePrice::where('end_date',null)->where('port_id',$port_start_id)->get();
		}
		// price entries with an enddate older than the date_price found -> apply other filters
		else {
			
			$fee_price_entry = FeePrice::where('end_date','>=',$date_price)->where('start_date','<=',$date_price)->where('port_id',$port_start_id)->get();
		}
		$port_fee_load = $fee_price_entry[0]->price; 
		
        return $port_fee_load;
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

		// Receive parameters from objects
		$date_price = $date->copy()->addDays($travel_time_to_start); // The date when the ship arrives the start port is relevant
		
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