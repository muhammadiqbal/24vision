<?php

namespace App\Http\Controllers;

use App\Models\ShipPosition;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Route;
use App\Models\Ship;
use App\Models\Region;
use App\Models\Port;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$shipPosition = ShipPosition::all()[0];
        $shipId = $request->input('shipId',1);
        if($shipId != null){
            $ship = Ship::find($shipId);
        }else{
            //default ship is the first one
            $ship = Ship::find(1);
        }
        $ships = Ship::all();
        $regions = Region::all();
        $ports = Port::all();
        $cargos = Cargo::where('ship_specialization_id', 
                                $ship->ship_specialization_id)
                                ->get();
        return view('calculator.index')//->with('shipPosition',$shipPosition)
                                       ->with('ship',$ship)
                                       ->with('cargos',$cargos)
                                       ->with('ships',$ships)
                                       ->with('regions',$regions)
                                       ->with('ports',$ports);
    }

    public function openPosition($port){
        $cargos = Cargo::where('port_id',$port);
        $shipPositions = ShipPosition::where('port_id',$port);

        return view('cargos.index')->with('cargos', $cargos)
                                   ->with('shipPositions',$shipPositions);
    }

	
	//Formular for calculating the NTCE for a cargo and given ship, ship position, fuel price and rate. 
	protected function calculateNTCE(Cargo $cargo, Ship $ship, Port $port_ship, Port $port_start, Port $port_end, $fuel_price, $rate){
		
		// Defining all parameter for the formular
		$voyage_time =calculateVoyageTime($cargo, $ship, $port_ship, $port_start, $port_end);
		$non_hire_costs = calculateNonHireCosts($cargo, $ship, $port_ship, $port_start, $port_end,$fuel_price);
		$voy_comm = $cargo->comission;
		$quantity = $cargo->quantity;
		
				
		// Formular for result of the function
		$ntce= ((1-$voy_comm)*$quantity*rate-$non_hire_costs)/$voyage_time

        return $ntce;
    }
	
	
	//Formular for calculating the GrossRate for a cargo and given ship position, fuel price and bdi. Uses Standardized BDI Ship (ID 1)
    protected function calculateGrossRate(Cargo $cargo, Ship $ship, Port $port_ship, Port $port_start, Port $port_end, $fuel_price, $bdi){
		
		// Defining all parameter for the formular
		$voyage_time =calculateVoyageTime($cargo, $ship, $port_ship, $port_start, $port_end);
		$non_hire_costs = calculateNonHireCosts($cargo, $ship, $port_ship, $port_start, $port_end,$fuel_price);
		$voy_comm = $cargo->comission;
		$quantity = $cargo->quantity;
		
				
		// Formular for result of the function
		$gross_rate= ($bdi*$voyage_time+$non_hire_costs)/((1-$voy_comm)*$quantity);

        return $gross_rate;
    }
	

	
	//Formular for calculating NonHireCosts (for NTCE or GrossRate) based on given cargo, ship, ship_position and fuel price
    protected function calculateNonHireCosts(Cargo $cargo, Ship $ship, Port $port_ship, Port $port_start, Port $port_end,$fuel_price){
		
		// Defining all parameter for the formular
		$port_fee_load = $port_start->fee;
		$port_fee_disch =$port_end->fee;
		$fuel_consumption = calculateFuelConsumption($cargo, $ship, $port_ship, $port_start, $port_end);
		
		// Formular for result of the function
		$non_hire_costs = $port_fee_load + $port_fee_disch + $fuel_price * $fuel_consumption;

        return $non_hire_costs;
    }	
	
	//Formular for calculating Fuel Consumption (for Non Hire Costse) based on given cargo, ship and ship_position 
	protected function calculateFuelConsumption(Cargo $cargo, Ship $ship, Port $port_ship, Port $port_start, Port $port_end){
		
		// Defining all parameter for the formular
		$port_time = calculatePortTime($cargo->quantity,$cargo->loading_rate,1,$cargo->discharging_rate,1);
		$travel_time = calculateTravelTime($port_ship, $port_start, $port_end,$ship->speed_ballast,$ship->speed_laden);
		$fuel_consumption_port = $ship->fuel_consumption_in_port;
		$fuel_consumption_travel = $ship->fuel_consumption_at_sea;
		
		// Formular for result of the function
		$fuel_consumption = $port_time*$fuel_consumption_port + $travel_time*$fuel_consumption_travel;

        return $fuel_consumption;
    }
	
	//Formular for calculating the Voyagage Time (for NTCE or Grossrate ) based on given cargo, ship and ship_position 
    protected function calculateVoyageTime(Cargo $cargo, Ship $ship, Port $port_ship, Port $port_start, Port $port_end){
		
		// Defining all parameter for the formular
		$port_time = calculatePortTime($cargo->quantity,$cargo->loading_rate,1,$cargo->discharging_rate,1);
		$travel_time = calculateTravelTime($port_ship, $port_start, $port_end,$ship->speed_ballast,$ship->speed_laden);
		
		// Formular for result of the function
		$voyage_time= $port_time + $travel_time;

        return $voyage_time;
    }	
	
	//Formular for calculating the Port Time (for Voyage Time and Fuel Consumption ) based on conrete attributes from a given cargo  
    protected function calculatePortTime($quantity,$load_speed,$load_factor,$disch_speed,$disch_factor){
	
		// Formular for result of the function
		$port_time= $quantity/$load_speed*$load_factor + $quantity/$disch_speed*$disch_factor;

        return $port_time;
    }		
	
	//Formular for calculating the Travel Time (for Voyage Time and Fuel Consumption )based on given ports of cargo and ship and concrete attributes from ship   
	protected function calculateTravelTime(Port $port_ship, Port $port_start, Port $port_end,$speed_ballast,$speed_laden){
		
		// Defining all parameter for the formular
		$distance_to_start = calculateDistance($port_ship->location_lat,$port_ship->location_lon,$port_start->location_lat,$port_start->location_lon);
		$distance_cargo = calculateDistance($port_start->location_lat,$port_start->location_lon,$port_end->location_lat,$port_end->location_lon);
		
		// Formular for result of the function
		$travel_time= $distance_to_start/$speed_ballast/(24*0.95) + $distance_cargo/$speed_laden/(24*0.95);

        return $travel_time;
    }
	
	
		//Formular for calculating direct distance between two points with given latidude and longitude
		// Based on: https://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php
	protected function calculateDistance($lat1, $lon1, $lat2, $lon2) {

		$theta = $lon1 - $lon2;
  		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  		$dist = acos($dist);
  		$dist = rad2deg($dist);
  		$miles = $dist * 60 * 1.1515;
		$nm = 0.868976 * $miles
		return $nm;
  }
}

}



