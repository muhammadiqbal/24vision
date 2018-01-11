<?php

namespace App\Http\Controllers;

use App\Models\ShipPosition;
use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Ship;
use App\Models\Region;
use App\Models\Distance;
use App\Models\Port;
use App\Models\Bdi;
use \League\Geotools\Coordinate\Coordinate;
use \League\Geotools\Geotools;
use App\Models\Email;
use DB;
use App\DataTables\CargoDataTable;
use App\Services\Calculator;

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


    public function testing(Calculator $calculator){
        // $cargo = Cargo::find(1);
        // $shipPosition =ShipPosition::find(1);
        // $ship = $shipPosition->ship;
        // $bdi =2300;
        // $fuel_price = 23;
        // $rate = 2300;
        // $port_ship = $shipPosition->port;

        // $grossRate = $this->calculateGrossRate($cargo, $shipPosition, $fuel_price, $bdi);
        // $ntce = $this->calculateNTCE($cargo, $shipPosition, $fuel_price, $rate);
        // $voyage_time = $this->calculateVoyageTime($cargo, $ship, $port_ship);
        // $non_hire_costs = $this->calculateNonHireCosts($cargo, $ship, $port_ship, $fuel_price);
        // $fuel_consumption = $this->calculateFuelConsumption($cargo, $ship, $port_ship);
        // $port_time = $this->calculatePortTime($cargo->quantity,$cargo->loading_rate,1,$cargo->discharging_rate,1);
        // $travel_time = $this->calculateTravelTime($port_ship, $cargo ,$ship->speed_ballast,$ship->speed_laden);

        // return 'cargo'.$cargo.'<br>'.
        //        'shiPosition'.$shipPosition.'<br>'.
        //        'ship:'.$ship.'<br>'.
        //        'bdi:'.$bdi.'<br>'.
        //        'fuel price:'.$fuel_price.'<br>'.
        //        'rate:'.$rate.'<br>'.
        //        'grossRate:'.$grossRate.'<br>'.
        //        'ntce:'.$ntce.'<br>'.
        //        'voyage_time:'.$voyage_time.'<br>'.
        //        'non_hire_costs'.$non_hire_costs.'<br>'.
        //        'fuel_consumption:'.$fuel_consumption.'<br>'.
        //        'port_time:'.$port_time.'<br>'.
        //        'travel_time:'.$travel_time.'<br>';

        //   $geotools = new \League\Geotools\Geotools();
        // $coordinateStartA = new Coordinate([24.18, 120.30]);
        // $coordinateStartB = new Coordinate([35.4, 139.45]);


        // // Defining all parameter for the formular
        // $distance_to_start = 0.868976 * $geotools->distance()->setFrom($coordinateStartA)->setTo($coordinateStartB)->in('mi')->haversine();
        
		
		//$email = new Email();

        //return $email->getTableColumns();
		
		
		$port_ship_id =  "1";
		$port_start_id = "2";
		
 		// Formular for result of the function
		$distance = Distance::where('start_port',$port_ship_id)->where('end_port',$port_start_id)->get();
		//$distance = $distance->where('distance','150.00')->get();
		//$distance_to_start = $distance[0]->distance;
		
		//$test = TRUE;
		if($distance ->isEmpty()) {
			$distance_to_start = "no value";
			}
		//return $distance_to_start;
		return $distance;
		
		
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CargoDataTable $cargoDataTable)
    {
         $shipId = $request->input('ship_id',1);
       //  $dateOfOpening = $request->input('date_of_opening');
       //  $portId = $request->input('port_id');



       //  $shipPosition = ShipPosition::where('ship_id',$shipId)->first();
         $ship = Ship::find($shipId);
         $ships = Ship::all();
         $ports = Port::all();
         $cargos = Cargo::all();
       //  $port_ship = $shipPosition->port;
        
        
       //  if(!empty($dateOfOpening) && !empty($portId)){
       //      $cargos = Cargo::where('ship_specialization_id', 
       //                              $ship->ship_specialization_id)
       //                      ->whereDate('laycan_first_day','>=',$dateOfOpening)
       //                      ->where('discharging_port',$portId)
       //                      ->get();
       //  }else{
       //      $cargos = Cargo::where('ship_specialization_id', 
       //                              $ship->ship_specialization_id)
       //                      ->whereDate('laycan_first_day','<=',$shipPosition->date_of_opening)
       //                      ->whereDate('laycan_last_day','>=',$shipPosition->date_of_opening)
       //                      ->where('quantity','<=',$ship->max_holds_capacity - 0)
       //                      //->where($ship->max_holds_capacity - 0,'>=','quantity')
       //                      ->get();
       //  }
                        
       //  $shipPositionGrossRate = ShipPosition::where('ship_id',1)->first();

       //  foreach ($cargos as $cargo) {
       //      $bdi = Bdi::find(1);
            
       //      $grossRate = $this->calculateGrossRate($cargo, $shipPositionGrossRate, 226, $bdi->price);

       //      $ntce = $this->calculateNTCE($cargo, $shipPosition,226, $grossRate);
            
       //      $route = Route::where('area1',$cargo->loading_port)
       //                    ->where('area3',$cargo->discharging_port)->first();
       //      if($route == null){
       //          $route = Route::find(1);
       //      }
            
       //      $cargo->setNtce($ntce);
       //      $cargo->setNtc($bdi->price);
       //      $cargo->setGrossRate($grossRate);
       //      $cargo->setRoute($route);
       //  }

       // // Datatables::of($cargos)->make(true);
        return $cargoDataTable->render('calculator.index')->with('ship',$ship)
                                       ->with('cargos',$cargos)
                                       ->with('ships',$ships)
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
        //+2 because there is one day extra for each port
		$port_time = ($quantity/$load_speed*$load_factor + $quantity/$disch_speed*$disch_factor)+2;

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



