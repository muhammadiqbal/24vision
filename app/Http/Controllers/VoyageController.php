<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ship;
use App\Models\Cargo;
use App\Models\Port;
use App\Services\Calculator;
use App\Models\FuelType;
use App\Models\CargoType;
use App\Models\Zone;
use App\Models\LdRateType;
use App\Models\QuantityMeasurement;
use App\Models\Bdi;

class VoyageController extends Controller
{

		
    function getVoyage(Ship $ship, Cargo $cargo, Port $port_ship,$date, Calculator $calculator){
		
		
		//$ship = Ship::find('2');
		//$port_ship = Port::find('1');
        //$cargo = Cargo::find('1');
		
		//$date = "20-12-2018";
		$date = Carbon::parse($date);
		$laycan_first_day =$calculator->formatLaycanFirst($cargo);
		$laycan_last_day =$calculator->formatLaycanLast($cargo);
		
		$ship_fuel_type = FuelType::find($ship->fuel_type_id)->name;
		if ($cargo->cargo_type_id != null) {	
		$cargo_name = CargoType::find($cargo->cargo_type_id)->name;
		} else { $cargo_name = "MISSING";}
		$cargo_stowage = $calculator->findStowage($cargo);
		//$cargo_quantity_type = QuantityMeasurement::find($cargo->quantity_measurement_id)->name;
		
		if ($cargo->loading_port != null) {
		$port_start = Port::find($cargo->loading_port);
		$port_start_name = $port_start->name;
		$port_start_max_laden_draft = $port_start->max_laden_draft;
		$port_start_draft_factor = $port_start->draft_factor;
		$port_start_zone = Zone::find($port_start->zone_id)->name;
		} else { 
		$port_start = null;
		$port_start_name = "MISSING";
		$port_start_max_laden_draft = null;
		$port_start_draft_factor = null;
		$port_start_zone = null;	
		}
		
		if ($cargo->loading_rate_type != null) {
		$port_start_rate_type = LdRateType::find($cargo->loading_rate_type)->name;
		$port_start_rate_factor = LdRateType::find($cargo->loading_rate_type)->rate_type_factor;
		} else {
		$port_start_rate_type = "MISSING";
		$port_start_rate_factor = 1;	
		}
		
		
		if ($cargo->discharging_port != null) {
		$port_end = Port::find($cargo->discharging_port);
		$port_end_name = $port_end->name;
		$port_end_max_laden_draft = $port_end->max_laden_draft;
		$port_end_draft_factor = $port_end->draft_factor;
		$port_end_zone = Zone::find($port_end->zone_id)->name;
		} else { 
		$port_end = null;
		$port_end_name = "MISSING";
		$port_end_max_laden_draft = null;
		$port_end_draft_factor = null;
		$port_end_zone = null;			
		}
		
		if ($cargo->discharging_rate_type != null) {
		$port_end_rate_type = LdRateType::find($cargo->discharging_rate_type)->name;
		$port_end_rate_factor = LdRateType::find($cargo->discharging_rate_type)->rate_type_factor;
		} else {
		$port_end_rate_type = "MISSING";
		$port_end_rate_factor = 1;	
		}
		
		$ship_bdi = Ship::find('1'); // Reference Ship for calculating tje GrossRate
		
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
		
		$travel_time_to_start_bdi = $calculator->calculateTravelTimeToStart($ship_bdi, $distance_to_start);
		$travel_time_cargo_bdi =  $calculator->calculateTravelTimeCargo($ship_bdi, $distance_cargo);
		$travel_time_sum_bdi = $calculator->calculateTravelTimeSum($travel_time_to_start_bdi, $travel_time_cargo_bdi);		
		$voyage_time_bdi = $calculator->calculateVoyageTime($port_time_sum, $travel_time_sum_bdi);	
		
		
		$fuel_consumption = $calculator->calculateFuelConsumption($ship, $port_time_sum, $travel_time_sum);
		$fuel_price =  $calculator->calculateFuelPrice($ship, $date, $travel_time_to_start);
		$fuel_costs =  $calculator->calculateFuelCosts($fuel_price,$fuel_consumption);
		$port_fee_load = $calculator->calculatePortFeeLoad($cargo, $date, $travel_time_to_start);
		//$port_fee_load = 10000;
		$port_fee_disch = $calculator->calculatePortFeeDisch($cargo, $date, $voyage_time, $port_time_disch);
		$non_hire_costs =  $calculator->calculateNonHireCosts($fuel_costs, $port_fee_load, $port_fee_disch);
		
		$fuel_consumption_bdi = $calculator->calculateFuelConsumption($ship_bdi, $port_time_sum, $travel_time_sum_bdi);
		$fuel_price_bdi =  $calculator->calculateFuelPrice($ship_bdi, $date, $travel_time_to_start_bdi);
		$fuel_costs_bdi =  $calculator->calculateFuelCosts($fuel_price_bdi,$fuel_consumption_bdi);
		$port_fee_load_bdi = $calculator->calculatePortFeeLoad($cargo, $date, $travel_time_to_start_bdi);
		//$port_fee_load_bdi = 10000;
		$port_fee_disch_bdi = $calculator->calculatePortFeeDisch($cargo, $date, $voyage_time_bdi, $port_time_disch);
		$non_hire_costs_bdi =  $calculator->calculateNonHireCosts($fuel_costs_bdi, $port_fee_load_bdi, $port_fee_disch_bdi);
		
		$bdi_id = $calculator->calculateBDIId($port_ship,$cargo);
		$bdi = $calculator->calculateBDI($bdi_id, $date, $travel_time_to_start);
		$gross_rate = $calculator->calculateGrossRate($cargo, $bdi, $voyage_time_bdi, $non_hire_costs_bdi);
		$ntce = $calculator->calculateNTCE($cargo, $bdi, $voyage_time, $non_hire_costs, $gross_rate);
		
		
		if ($bdi_id != null) {
		$bdi_code= Bdi::find($bdi_id)->code;
		$bdi_name= Bdi::find($bdi_id)->name;
		} else { 
		$bdi_code = null;
		$bdi_name = null;
		}
		//$route = $calculator->findRoute($route_id);

    	return view('voyages.index')
		->with('ship',$ship)
		->with('cargo',$cargo)
		->with('port_ship',$port_ship)
		->with('date',$date)
		
		->with('ship_fuel_type',$ship_fuel_type)
		->with('cargo_name',$cargo_name)
		->with('cargo_stowage',$cargo_stowage)
		//->with('cargo_quantity_type',$cargo_quantity_type )
		
		->with('port_start', $port_start)
		->with('port_start_name',$port_start_name)
		->with('port_start_max_laden_draft',$port_start_max_laden_draft)
		->with('port_start_draft_factor',$port_start_draft_factor)
		->with('port_start_rate_type',$port_start_rate_type)
		->with('port_start_rate_factor',$port_start_rate_factor)
		->with('port_start_zone',$port_start_zone )
		->with('port_end',$port_end)
		->with('port_end_name',$port_end_name)
		->with('port_end_max_laden_draft',$port_end_max_laden_draft)
		->with('port_end_draft_factor',$port_end_draft_factor)
		->with('port_end_rate_type',$port_end_rate_type )
		->with('port_end_rate_factor',$port_end_rate_factor)
		->with('port_end_zone',$port_end_zone )
		
		->with('distance_to_start',$distance_to_start)
		->with('distance_cargo',$distance_cargo)
		->with('distance_sum',	$distance_sum)
		->with('travel_time_to_start',$travel_time_to_start)
		->with('travel_time_cargo',$travel_time_cargo)
		->with('travel_time_sum',$travel_time_sum)
		->with('port_time_load',$port_time_load)
		->with('port_time_disch',$port_time_disch)
		->with('port_time_sum',$port_time_sum)
		->with('voyage_time',$voyage_time)
		->with('fuel_consumption',$fuel_consumption)
		->with('fuel_price',$fuel_price)
		->with('fuel_costs',$fuel_costs)
		->with('port_fee_load',$port_fee_load)
		->with('port_fee_disch',$port_fee_disch)
		
		->with('non_hire_costs',$non_hire_costs)
		->with('bdi',$bdi)
		->with('gross_rate',$gross_rate)
		->with('ntce',$ntce)
		->with('bdi_code',$bdi_code)
		->with('bdi_name',$bdi_name)
		->with('laycan_first_day',$laycan_first_day)
		->with('laycan_last_day',$laycan_last_day);
    }
}

		$port_end_name = null;
		$port_end_max_laden_draft = null;
		$port_end_draft_factor = null;