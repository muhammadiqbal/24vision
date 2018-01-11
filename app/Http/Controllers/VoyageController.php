<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ship;
use App\Models\Cargo;
use App\Models\Port;
use App\Library\Services\Calculator;

 

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
		->with('ntce',$ntce)
		->with('ship',$ship);
    }
}
