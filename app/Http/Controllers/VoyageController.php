<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ship;
use App\Models\Cargo;
use App\Models\Port;
use App\Services\Calculator;

 

class VoyageController extends Controller
{
    //

    function getVoyage(Ship $ship, Cargo $cargo, Port $port_ship,$date, Calculator $calculator){
	$distance_to_start = $calculator->calculateDistancetoStart($port_ship, $cargo);
	$distance_cargo =  $calculator->calculateDistancetoCargo($cargo);
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
	$ntce = $calculator->calculateNTCE($cargo, $bdi, $voyage_time, $non_hire_costs, $rate);

    	return view('voyages.index')
		->with('ship',$ship)
		->with('cargo',$cargo)
		->with('port_ship',$port_ship)
		->with('date',$date)
		->with('distance_to_start',$distance_to_start)
		->with('distance_cargo',$distance_cargo)
		->with('travel_time_to_start',$travel_time_to_start)
		->with('travel_time_cargo',$travel_time_cargo)
		->with('travel_time_sum',$travel_time_sum)
		->with('port_time_load',$port_time_load)
		->with('port_time_disch',$port_time_disch)
		->with('port_time_sum',$port_time_sum)
		->with('voyage_time',$voyage_time)
		->with('fuel_consumption',$fuel_consumption)
		->with('fuel_price',$fuel_price)
		->with('port_fee_load',$port_fee_load)
		->with('port_fee_disch',$port_fee_disch)
		->with('non_hire_costs',$non_hire_costs)
		->with('bdi',$bdi)
		->with('gross_rate',$gross_rate)
		->with('ntce',$ntce)
);
    }
}
