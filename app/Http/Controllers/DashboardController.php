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

        return $dashboardDataTable
                                  ->forOccTonnage($occupied_tonage)
                                  ->forOccSize($occupied_size)
                                  ->forShip($selectedShip)
                                  ->forPort($port)
                                  ->forDateOfOpening($date_of_opening)
                                  ->render('calculator.index',
                                            ['ships'=>$ships, 
                                             'ports'=>$ports,
                                             'selectedShip'=>$selectedShip,
                                             'occupied_size'=>$occupied_size,
                                             'occupied_tonage'=>$occupied_tonage,
                                             'date_of_opening'=>$date_of_opening,
                                             'mailCount'=>$mailCount,
                                             'cargoCount'=>$cargoCount,
                                             'shipCount'=>$shipCount
                                            ]);
    }

}



