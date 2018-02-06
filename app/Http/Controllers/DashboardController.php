<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ShipPosition;
use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Ship;
use App\Models\Region;
use App\Models\Distance;
use App\Models\Port;
use App\Models\FeePrice;
use App\Models\Bdi;
use App\Models\CargoOffer;
use App\Models\ShipOffer;
use App\Models\ShipOfferExtracted;
use App\Models\ShipOrder;
use App\Models\ShipOrderExtracted;
use \League\Geotools\Coordinate\Coordinate;
use \League\Geotools\Geotools;
use App\Models\Email;
use DB;
use App\DataTables\DashboardDataTable;
use App\Services\Calculator;
use App\Models\LdRateType;

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
		
		/*$ship = Ship::find('2');
        $port_ship = Port::find('1');
        $cargo = Cargo::find('1');
		$date = Cargo::find('1')->laycan_first_day;
		$date = "20-08-2018";
		$date = Carbon::parse($date);
		
		$distance_to_start = $calculator->calculateDistancetoStart($port_ship, $cargo, $calculator);
		$distance_cargo =  $calculator->calculateDistancetoCargo($cargo, $calculator);
		$distance_sum = $calculator->calculateDistanceSum($distance_to_start, $distance_cargo);
		$travel_time_to_start = $calculator->calculateTravelTimeToStart($ship, $distance_to_start);
		$travel_time_cargo =  $calculator->calculateTravelTimeCargo($ship, $distance_cargo);
		$travel_time_sum = $calculator->calculateTravelTimeSum($travel_time_to_start, $travel_time_cargo);
		$port_time_load = $calculator->calculatePortTimeLoad($cargo);
		$port_time_disch = $calculator->calculatePortTimeDisch($cargo);
		$port_time_sum = $calculator->calculatePortTimeSum($port_time_load, $port_time_disch);
		$voyage_time = $calculator->calculateVoyageTime($port_time_sum, $travel_time_sum);
	
		$fuel_consumption = $calculator->calculateFuelConsumption($ship, $port_time_sum, $travel_time_sum);
		$fuel_price =  $calculator->calculateFuelPrice($ship, $date, $travel_time_to_start);
		$port_fee_load = $calculator->calculatePortFeeLoad($cargo, $date, $travel_time_to_start);
		$port_fee_disch = $calculator->calculatePortFeeDisch($cargo, $date, $voyage_time, $port_time_disch);
		$non_hire_costs =  $calculator->calculateNonHireCosts($fuel_consumption, $fuel_price, $port_fee_load, $port_fee_disch);

		$bdi = $calculator->calculateBDI($port_ship, $cargo, $date, $travel_time_to_start);
		$gross_rate = $calculator->calculateGrossRate($cargo, $bdi, $voyage_time, $non_hire_costs);
		$ntce = $calculator->calculateNTCE($cargo, $bdi, $voyage_time, $non_hire_costs, $gross_rate);
		
		
		$x = array(
					$port_fee_load,
					$distance_to_start,
					$distance_cargo,
					$distance_sum,
					$travel_time_to_start,
					$travel_time_cargo,
					$travel_time_sum,
					$port_time_load, 
					$port_time_disch,
					$port_time_sum,
					$voyage_time,
					$fuel_consumption,
					$fuel_price,

					$port_fee_disch,
					$non_hire_costs,
					$bdi,
					$gross_rate,
					$ntce 
					);
					
		
		
		//return $x;
		$port_start_id = $cargo->loading_port;
		$date_price = $date;//->addDays($travel_time_to_start);  // The date when the ship arrives the start port is relevant
		
		// Formular for result of the function
		$fee_price_entry = FeePrice::where('end_date','>',$date_price)->get();
		
		return $fee_price_entry;
		// No price entry has an enddate older than the date_price -> use the latest entry with end date null
		if ($fee_price_entry = FeePrice::where('end_date','>',$date_price)->get()->isEmpty()) {

			$fee_price_entry = FeePrice::where('end_date',null)->where('port_id',$port_start_id)->get();
		}
		// price entries with an enddate older than the date_price found -> apply other filters
		else {
			return 100;
			$fee_price_entry = FeePrice::where('end_date','>',$date_price)->where('start_date','<',$date_price)->where('port_id',$port_start_id)->get();
		}
		$port_fee_load = $fee_price_entry[0]->price; 
		
        return $port_fee_load;
		
		
		$x = null;
		$y = 1;
		$z = $y +$x ;
		
		
		$load_factor = LdRateType::find(null)->rate_type_factor;
		return $load_factor;*/

        $cargoOffer = new CargoOffer; 
        $shipOffer = new ShipOffer; 
        $shipOfferExtracted = new ShipOfferExtracted; 
        $shipOrder = new ShipOrder;
        $shipOrderExtracted = new ShipOrderExtracted;

        return array($cargoOffer->getTableColumns(), $shipOffer->getTableColumns(), $shipOfferExtracted->getTableColumns(), $shipOrder->getTableColumns(),$shipOrderExtracted->getTableColumns());


		$cargo = Cargo::find(2);
		if($cargo->laycan_last_day != null){ 
		  $x= $cargo->laycan_last_day->format('m/d/Y');
		} else{
            $x= null;
        }
		
		return $x;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DashboardDataTable $dashboardDataTable, Calculator $calculator)
    {
         //$shipId = $request->input('ship_id',1);
         //$ship = Ship::find(1);
         $ships = Ship::all();
         $ports = Port::all();
         if($request->input('ship_id')){
            $selectedShip = Ship::find($request->input('ship_id'));
         }else {
            $selectedShip = Ship::first();
         }

         if($request->input('port_id')){
            $port = Port::find($request->input('port_id'));;
         }else{
            $port = Port::first();
         }

         $occupied_size = $request->input('occupied_size',0);
         $occupied_tonage = $request->input('occupied_tonage',0);
         $date_of_opening = $request->input('date_of_opening',date('d-m-Y'));

         $mailCount = Email::count();
         $cargoCount = Cargo::count();
         $shipCount = Ship::count();
         $cargos = Cargo::leftjoin('cargo_status', 'cargo_status.id','cargo_status.id')
                        ->leftjoin('cargo_types', 'cargos.cargo_type_id','cargo_types.id')
                        ->leftjoin('ports as p1', 'p1.id','loading_port')
                        ->leftjoin('ports as p2', 'p2.id','discharging_port')
                        ->where('quantity','<=', ($selectedShip->dwcc - $occupied_tonage))
                        // ->where(DB::raw('quantity * stowage_factor AS size'),
                        //                 '<=',
                        //                 ($this->ship->max_holds_capacity - $this->occupied_size))
                        // ->where(DB::raw('quantity *'.$this->ship->ballast_draft),
                        //                 '<=', 
                        //                 ($this->ship->max_laden_draft-($this->ship->ballast_draft * $this->occupied_tonage)))
                        ->select('cargos.*','cargo_status.name as status','cargo_types.name as type', 'p1.name as load_port', 'p2.name as disch_port');
                        if($request()->get('port_id')){
                            $cargos->where('loading_port',$request()->get('port_id'));
                        }
                        if($request()->get('date_of_opening')){
                            $cargos->whereDate('laycan_first_day','>=',date($request()->get('date_of_opening')))
                                   ->whereDate('laycan_last_day','<=',date($request()->get('date_of_opening')));

        return $dashboardDataTable
                                  // ->forOccTonnage($occupied_tonage)
                                  // ->forOccSize($occupied_size)
                                  // ->forShip($selectedShip)
                                  // ->forPort($port)
                                  // ->forDateOfOpening($date_of_opening)
                                  ->render('calculator.index',
                                            ['ships'=>$ships, 
                                             'ports'=>$ports,
                                             'selectedShip'=>$selectedShip,
                                             'occupied_size'=>$occupied_size,
                                             'occupied_tonage'=>$occupied_tonage,
                                             'date_of_opening'=>$date_of_opening,
                                             'mailCount'=>$mailCount,
                                             'cargoCount'=>$cargoCount,
                                             'shipCount'=>$shipCount,
                                             'cargos'=>$cargos
                                            ]);
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



