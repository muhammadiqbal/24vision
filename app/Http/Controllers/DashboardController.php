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
    public function index(Request $request)
    {
        //$shipPosition = ShipPosition::all()[0];
        $shipId = $request->input('shipId',1);
        if($shipId != null){
            $ship = Ship::find($shipId);
        }else{
            //default ship is the first one
            $ship = Ship::find(1);
        }
        $ships = Ship::all();
        $regions = Region::all();
        $ports = Port::all();
        $cargos = Cargo::where('ship_specialization_id', 
                                $ship->ship_specialization_id)
                                ->get();
        return view('calculator.index')//->with('shipPosition',$shipPosition)
                                       ->with('ship',$ship)
                                       ->with('cargos',$cargos)
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
