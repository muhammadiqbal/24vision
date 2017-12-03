<?php

namespace App\Http\Controllers;

use App\Models\ShipPosition;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Route;

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
    public function index()
    {
        $shipPosition = ShipPosition::all()[0];
        return view('calculator.index')->with(['shipPosition'=>$shipPosition]);
    }


    public function openPosition($port){
        $cargos = Cargo::where('port_id',$port);
        $shipPositions = ShipPosition::where('port_id',$port);

        return view('cargos.index')->with('cargos', $cargos)
                                   ->with('shipPositions',$shipPositions);
    }

    protected function calculateNTC(Ship $ship, Cargo $cargo, Bdi $bdi){

        return $ntc;
    }

    protected function calculateNTCE(){

        return $ntce;
    }

    protected function calculateGrossRate(){

        return $grossRate;
    }
}
