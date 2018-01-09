<?php
namespace App\Library\Services;
  
class Calculator
{
    //Formular for calculating (and storing) the Distance to start, used for calculating TravelTimeToStart
	public function calculateDistancetoStart(Port $port_ship, Cargo $cargo){
		
		// Receive parameters from objects
		$port_ship_id =  $port_ship->id;
		$port_start_id = $cargo->loading_port;
 		
		// Formular for result of the function
*		if ("XXXThere is an entry in table 'distances' that has port_ship_id as start_port and port_start_id as end_port XXX") {
*			$distance_to_start = "XXX function that calls 'distance' from table 'distances' based on the given port sXXX";
		} else {
			
*			$distance_to_start = "XXXfunction that calls the distance calculator from Tsuang Hao with the 2 given ports XXX";;
*			"XXX Insert the new calculated distances into the table 'distances', create 2 entries, the second withs witched ports XXX";
		}

        return $distance_to_start;
    }

	//Formular for calculating the Distance for cargo, used for calculating TravelTimeCargo
	public function calculateDistancetoCargo(Cargo $cargo){
		
		// Receive parameters from objects
		$port_start_id = $cargo->loading_port;
		$port_end_id = $cargo->discharging_port;
 		
		// Formular for result of the function
*		if ("XXXThere is an entry in table 'distances' that has port_start_id as start_port and port_end_id as end_port XXX") {
*			$distance_cargo = "XXX function that calls 'distance' from table 'distances' based on the given port sXXX";
		} else {
			
*			$distance_cargo = "XXXfunction that calls the distance calculator from Tsuang Hao with the 2 given ports XXX";;
*			"XXX Insert the new calculated distances into the table 'distances', create 2 entries, the second withs witched ports XXX";
		}

        return $distance_cargo;
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
		$ravel_time_cargo= $distance_cargo/$speed_laden/(24*0.95);

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
		$load_factor = Loading_disscharging_rate_type::find($cargo->loading_rate_type)->factor;
	
		
		// Formular for result of the function
        //+1 because there is one day extra for each port
		$port_time_load = $quantity/$load_speed*$load_factor +1;

        return $port_time_load;
    }	

	
	//Formular for calculating the Port Time for Discharging, used for calculating PortTimeSum and extracting PortFeeDisch
    public function calculatePortTimeDisch(Cargo $cargo){
		
		$quantity = $cargo->quantity;
		$disch_speed = $cargo->discharging_rate;
		$disch_factor = Loading_disscharging_rate_type::find($cargo->discharging_rate_type)->factor;
	
		
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

	
	//Formular for calculating Fuel Consumption, used for NonHireCostse 
	public function calculateFuelConsumption(Ship $ship, $port_time_sum, $travel_time_sum){

		// Receive parameters from objects
		$fuel_consumption_port = $ship->fuel_consumption_in_port;
		$fuel_consumption_travel = $ship->fuel_consumption_at_sea;
		
		// Formular for result of the function

		$fuel_consumption = $port_time_sum*$fuel_consumption_port + $travel_time_sum*$fuel_consumption_travel;

        return $fuel_consumption;
    }
	
	//Formular for extract Fuel Price from table "fuel_prices", used for calculating NonHireCosts 
	public function calculateFuelPrice(Ship $ship, $date, $travel_time_to_start){

		// Receive parameters from objects
		$fuel_type_id = $ship->fuel_type_id;
		$date_price = $this->addDayswithdate($date, $travel_time_to_start); // The date when the ship arrives the start port is relevant
		
		// Formular for result of the function

*		$fuel_price= "XXX Function that receive price from table 'fuel_price' based on $fuel_type_id and 'start_date'<$date_price<'end_date' XXX";

        return $fuel_price;
    }
	
	//Formular for extract Port Fee for Loading  from table "Fee_prices", used for calculating NonHireCosts  
	public function calculatePortFeeLoad(Cargo $cargo, $date, $travel_time_to_start){

		// Receive parameters from objects
		$port_start_id = $cargo->loading_port;
		$date_price = $this->addDayswithdate($date, $travel_time_to_start);  // The date when the ship arrives the start port is relevant
		
		// Formular for result of the function

*		$port_fee_load= "XXX Function that receive price from table 'fee_prices' based on $port_start_id and 'start_date'<$date_price<'end_date' XXX";

        return $port_fee_load;
    }

	//Formular for extract Port Fee for Discharging from table "Fee_prices", used for calculating NonHireCosts 
	public function calculatePortFeeDisch(Cargo $cargo, $date, $voyage_time, $port_time_disch){

		// Receive parameters from objects
		$port_end_id = $cargo->discharching_port;
		$days = $voyage_time - $port_time_disch
		$date_price = $this->addDayswithdate($date, $days); // The date when the ship arrives the end port is relevant
		
		// Formular for result of the function

*		$port_fee_disch= "XXX Function that receive price from table 'fee_prices' based on $port_end_id and 'start_date'<$date_price<'end_date' XXX";

        return $port_fee_disch;
    }
	

	//Formular for calculating the NonHireCosts, used for calculating Grossrate and NTCE 
    public function calculateNonHireCosts($fuel_consumption, $fuel_price, $port_fee_load, $port_fee_disch)
    {
	
		// Formular for result of the function
		$non_hire_costs = $port_fee_load + $port_fee_disch + $fuel_price * $fuel_consumption;

        return $non_hire_costs;
    }	

	
	//Formular for extract BDI Price from table "bdi_prices", used for calculating Grossrate and NTCE 
	public function calculateBDI(Port $port_ship, Cargo $cargo, $date, $travel_time_to_start){

		// Receive parameters from objects
		$date_price = $this->addDayswithdate($date, $travel_time_to_start); // The date when the ship arrives the start port is relevant
		
		$port_ship_zone =  $port_ship->zone_id;
		$port_start_id = $cargo->loading_port;
		$port_start_zone = Port::find($port_start_id)->zone_id;
 		$port_end_id = $cargo->discharging_port;
		$port_end_zone = Port::find($port_end_id)->zone_id;
		
		// Find the right bdi_id
		// Step 1:  find matching path
*		if ($port_ship_zone == $port_start_zone OR $port_start_zone == $port_end_zone ) {
*			$paths = "XXX function that returns 'path_id' from table 'paths' based on $port_ship_zone =zone 1, Null= zone2 and $port_end_zone = zone 3   ";
		} else {
*			$paths = "XXX function that returns 'path_id' from table 'paths' based on $port_ship_zone =zone 1, $port_start_zone= zone2 and $port_end_zone = zone 3   ";
		}
		
		// Step 1b: If no path is found, continue with the bdi_id for the average bdi price
*		if ($paths=NULL){ "XXXrequires that if no paths is found with given combination of zones, it returns NULL instead of an error XXX" 
			$bdi_id = 540666;
		) else {
		// Step 2: determine route for path
		$route = Paths::find($paths)->route_id;
		// Step 3: determine bdi_id for route
		$bdi_id = Routes::find($route)->bdi_id;
		}
		
		// Formular for result of the function

*		$bdi= "XXX Function that receive price from table 'bdi_price' based on $bdi_id and 'start_date'<$date_price<'end_date' XXX";

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