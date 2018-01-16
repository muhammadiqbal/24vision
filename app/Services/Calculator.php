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
use App\Models\CargoType;
use App\Models\StowageFactorUnit;

class Calculator
{


	

	//Formular for finding Stowage an return attributes as array
	public function findStowage(Cargo $cargo){
		
		
		$stowage_factor = $cargo->stowage_factor;
		$stowage_factor_unit = $cargo->sf_unit;
		
		if ($stowage_factor==null OR $stowage_factor_unit==null ) {
			$cargo_type = CargoType::find($cargo->cargo_type_id);	
			$stowage_factor = $cargo_type->stowage_factor;
			$stowage_factor_unit = $cargo_type->sf_unit;	
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
		
		$quantity = $cargo->quantity;
		$load_speed = $cargo->loading_rate;
		$load_factor = LdRateType::find($cargo->loading_rate_type)->rate_type_factor;
	
		
		// Formular for result of the function
        //+1 because there is one day extra for each port
		$port_time_load = $quantity/$load_speed*$load_factor +1;

        return $port_time_load;
    }	

	
	//Formular for calculating the Port Time for Discharging, used for calculating PortTimeSum and extracting PortFeeDisch
    public function calculatePortTimeDisch(Cargo $cargo){
		
		$quantity = $cargo->quantity;
		$disch_speed = $cargo->discharging_rate;
		$disch_factor = LdRateType::find($cargo->discharging_rate_type)->rate_type_factor;
	
		
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
		$port_start_zone = Port::find($port_start_id)->zone_id;
 		$port_end_id = $cargo->discharging_port;
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
		
		// Formular for result of the function
		$gross_rate= ( $bdi * $voyage_time + $non_hire_costs) / ((1 - $voy_comm) * $quantity);

     return $gross_rate;
   }

   //Formular for calculating the NTCE, used as final result 
  	public function calculateNTCE(Cargo $cargo, $bdi, $voyage_time, $non_hire_costs, $rate){
		
		// Receive parameter from objects
        $voy_comm = $cargo->comission/100;
        $quantity = $cargo->quantity;
		
		// Formular for result of the function
		$ntce= (((1 - $voy_comm) * $quantity * $rate) - $non_hire_costs ) / $voyage_time;

        return $ntce;
    } 
	
}