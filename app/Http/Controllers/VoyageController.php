<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ship;
use App\Models\Cargo;
use App\Models\Port;

 

class VoyageController extends Controller
{
    //

    function getVoyage(Ship $ship, Cargo $cargo, Port $port_ship,$date){
	$distance_to_start = calculateDistancetoStart($port_ship, $cargo);
	$distance_cargo =  calculateDistancetoCargo($cargo);
	$travel_time_to_start = calculateTravelTimeToStart($ship, $distance_to_start);
	$travel_time_cargo =  calculateTravelTimeCargo($ship, $distance_cargo);
	$travel_time_sum = calculateTravelTimeSum($travel_time_to_start, $travel_time_cargo);
	$port_time_load = calculatePortTimeLoad($cargo);
	$port_time_disch = calculatePortTimeDisch($cargo);
	$port_time_sum = calculatePortTimeSum($port_time_load, $port_time_disch);
	$voyage_time = calculateVoyageTime($port_time_sum, $travel_time_sum);
	
	$fuel_consumption = calculateFuelConsumption($ship, $port_time_sum, $travel_time_sum);
	$fuel_price =  calculateFuelPrice($ship, $date, $travel_time_to_start);
	$port_fee_load = calculatePortFeeLoad($cargo, $date, $travel_time_to_start);
	$port_fee_disch = calculatePortFeeDisch($cargo, $date, $voyage_time, $port_time_disch);
	$non_hire_costs =  calculateNonHireCosts($fuel_consumption, $fuel_price, $port_fee_load, $port_fee_disch);

	$bdi = calculateBDI($port_ship, $cargo, $date, $travel_time_to_start);
	$gross_rate = calculateGrossRate($cargo, $bdi, $voyage_time, $non_hire_costs);
	$ntce = calculateNTCE($cargo, $bdi, $voyage_time, $non_hire_costs, $rate);

    	return view('voyages.index');
    }
}
