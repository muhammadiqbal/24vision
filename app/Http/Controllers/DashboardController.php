<?php

namespace App\Http\Controllers;

use App\Models\ShipPosition;
use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Ship;
use App\Models\Region;
use App\Models\Port;
use App\Models\Bdi;
use \League\Geotools\Coordinate\Coordinate;
use \League\Geotools\Geotools;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function testing(){

        return $testResultValue;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shipId = $request->input('ship_id',1);
        $shipPosition = ShipPosition::where('ship_id',$shipId)->first();
        
        $ship = Ship::find($shipId);
        $ships = Ship::whereIn('id',ShipPosition::all('ship_id'))->get();
        $regions = Region::all();
        $ports = Port::all();
        $cargos = Cargo::where('ship_specialization_id', 
                                $ship->ship_specialization_id)
                                ->get();

        foreach ($cargos as $cargo) {
            $bdi = Bdi::find(1);
            $grossRate = $this->calculateGrossRate($cargo, $shipPosition, 23, $bdi->price);
            $ntce = $this->calculateNTCE($cargo, $shipPosition,23, 2302);
            
            $route = Route::where('area1',$cargo->loading_port)
                          ->where('area3',$cargo->discharging_port)->first();
            if($route == null){
                $route = Route::find(1);
            }
            
            $cargo->setNtce($ntce);
            $cargo->setNtc($bdi->price);
            $cargo->setGrossRate($grossRate);
            $cargo->setRoute($route);
        }

       // Datatables::of($cargos)->make(true);
        return view('calculator.index')->with('shipPosition',$shipPosition)
                                       ->with('ship',$ship)
                                       ->with('cargos',$cargos)
                                       ->with('ships',$ships)
                                       ->with('regions',$regions)
                                       ->with('ports',$ports);
    }



        //Formular for calculating the GrossRate for a cargo and given ship position, fuel price and bdi. Uses Standardized BDI Ship (ID 1)
    protected function calculateGrossRate(Cargo $cargo, ShipPosition $ship_position, $fuel_price, $bdi){
        
        $ship = $ship_position->ship;
        $port_ship = $ship_position->port;

        $port_start = $cargo->loading_port;
        $port_end = $cargo->discharging_port;

        // Defining all parameter for the formular
        $voyage_time = $this->calculateVoyageTime($cargo, $ship, $port_ship);
        $non_hire_costs = $this->calculateNonHireCosts($cargo, $ship, $port_ship, $fuel_price);
        $voy_comm = $cargo->comission/100;
        $quantity = $cargo->quantity;
                        
        // Formular for result of the function
        $gross_rate= ( $bdi * $voyage_time + $non_hire_costs) / ((1 - $voy_comm) * $quantity);

        return $gross_rate;
    }

        //Formular for calculating the Voyagage Time (for NTCE or Grossrate ) based on given cargo, ship and ship_position 
    protected function calculateVoyageTime(Cargo $cargo, Ship $ship, Port $port_ship){
        
        $port_start = $cargo->loading_port;
        $port_end = $cargo->discharging_port;

        // Defining all parameter for the formular
        $port_time = $this->calculatePortTime($cargo->quantity,$cargo->loading_rate,1,$cargo->discharging_rate,1);
        $travel_time = $this->calculateTravelTime($port_ship, $cargo ,$ship->speed_ballast,$ship->speed_laden);
        
        // Formular for result of the function
        $voyage_time = $port_time + $travel_time;

        return $voyage_time;
    }

	
	//Formular for calculating the NTCE for a cargo and given ship, ship position, fuel price and rate. 
	protected function calculateNTCE(Cargo $cargo, ShipPosition $ship_position, $fuel_price, $rate){
		
        $ship = $ship_position->ship;
        $port_ship = $ship_position->port;

        $port_start = $cargo->loading_port;
        $port_end = $cargo->discharging_port;

		// Defining all parameter for the formular
		$voyage_time = $this->calculateVoyageTime($cargo, $ship, $port_ship);
		$non_hire_costs = $this->calculateNonHireCosts($cargo, $ship, $port_ship, $fuel_price);
		$voy_comm = $cargo->comission/100;
		$quantity = $cargo->quantity;
		
				
		// Formular for result of the function
		$ntce= (((1 - $voy_comm) * $quantity * $rate) - $non_hire_costs ) / $voyage_time;

        return $ntce;
    }
		
	//Formular for calculating NonHireCosts (for NTCE or GrossRate) based on given cargo, ship, ship_position and fuel price
    protected function calculateNonHireCosts(Cargo $cargo, Ship $ship, Port $port_ship, $fuel_price)
    {
		
        $port_fee_load = $cargo->loadingPort->fee;
        $port_fee_disch = $cargo->dischargingPort->fee;

		$fuel_consumption = $this->calculateFuelConsumption($cargo, $ship, $port_ship);
		
		// Formular for result of the function
		$non_hire_costs = $port_fee_load + $port_fee_disch + $fuel_price * $fuel_consumption;

        return $non_hire_costs;
    }	
	
	//Formular for calculating Fuel Consumption (for Non Hire Costse) based on given cargo, ship and ship_position 
	protected function calculateFuelConsumption(Cargo $cargo, Ship $ship, Port $port_ship){
		
        $port_start = $cargo->loading_port;
        $port_end = $cargo->discharging_port;

		// Defining all parameter for the formular
		$port_time = $this->calculatePortTime($cargo->quantity,$cargo->loading_rate,1,$cargo->discharging_rate,1);
		$travel_time = $this->calculateTravelTime($port_ship, $cargo ,$ship->speed_ballast,$ship->speed_laden);
		$fuel_consumption_port = $ship->fuel_consumption_in_port;
		$fuel_consumption_travel = $ship->fuel_consumption_at_sea;
		
		// Formular for result of the function
		$fuel_consumption = $port_time*$fuel_consumption_port + $travel_time*$fuel_consumption_travel;

        return $fuel_consumption;
    }
	
	
	
	//Formular for calculating the Port Time (for Voyage Time and Fuel Consumption ) based on conrete attributes from a given cargo  
    protected function calculatePortTime($quantity,$load_speed,$load_factor,$disch_speed,$disch_factor){
	
		// Formular for result of the function
		$port_time = $quantity/$load_speed*$load_factor + $quantity/$disch_speed*$disch_factor;

        return $port_time;
    }		
	
	//Formular for calculating the Travel Time (for Voyage Time and Fuel Consumption )based on given ports of cargo and ship and concrete attributes from ship   
	protected function calculateTravelTime(Port $port_ship, Cargo $cargo, $speed_ballast,$speed_laden){
		
        $port_start = $cargo->loadingPort;
        $port_end = $cargo->dischargingPort;

        $geotools = new \League\Geotools\Geotools();
        $coordinateStartA = new Coordinate([$port_ship->latitude, $port_ship->longitude]);
        $coordinateStartB = new Coordinate([$port_start->latitude, $port_start->longitude]);
        
        $coordinateCargoA = new Coordinate([$port_start->latitude,$port_start->longitude]);
        $coordinateCargoB = new Coordinate([$port_end->latitude,$port_end->longitude]);

		// Defining all parameter for the formular
		$distance_to_start = 0.868976 * $geotools->distance()->setFrom($coordinateStartA)->setTo($coordinateStartB)->in('mi')->haversine();

		$distance_cargo = 0.868976 * $geotools->distance()->setFrom($coordinateCargoA)->setTo($coordinateCargoB)->in('mi')->haversine();
		
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
		$nm = 0.868976 * $miles;
		return $nm;
  }

}



