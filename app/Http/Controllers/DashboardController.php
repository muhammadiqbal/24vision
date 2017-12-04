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
    public function index()
    {
        $shipPosition = ShipPosition::all()[0];
        $ships = Ship::all();
        $regions = Region::all();
        $ports = Port::all();
        return view('calculator.index')->with('shipPosition',$shipPosition)
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


    protected function calculateNTCE(Ship $ship, Cargo $cargo, Bdi $bdi){

        return $ntce;
    }

    protected function calculateGrossRate(){

        return $grossRate;
    }
}
