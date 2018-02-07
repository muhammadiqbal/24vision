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
use Response;

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


    public function testing(Request $request,Calculator $calculator){
    		$cargos = Cargo::all();
        // leftjoin('cargo_status', 'cargo_status.id','cargo_status.id')
        //                 ->leftjoin('cargo_types', 'cargos.cargo_type_id','cargo_types.id')
        //                 ->leftjoin('ports as p1', 'p1.id','loading_port')
        //                 ->leftjoin('ports as p2', 'p2.id','discharging_port')
        //                 ->where('quantity','<=', (1002000))
        //                 // ->where(DB::raw('quantity * stowage_factor AS size'),
        //                 //                 '<=',
        //                 //                 ($this->ship->max_holds_capacity - $this->occupied_size))
        //                 // ->where(DB::raw('quantity *'.$this->ship->ballast_draft),
        //                 //                 '<=', 
        //                 //                 ($this->ship->max_laden_draft-($this->ship->ballast_draft * $this->occupied_tonage)))
        //                 ->select('cargos.*','cargo_status.name as status','cargo_types.name as type', 'p1.name as load_port', 'p2.name as disch_port');
        if($request->input('port_id')){
            $cargos->where('loading_port',3);
        }
        if($request->input('date_of_opening')){
            $cargos->whereDate('laycan_first_day','>=',date())
                   ->whereDate('laycan_last_day','<=',date());
        }
       
        foreach ($cargos as $cargo) {
            $cargo->setNtce(Port::find(1),Ship::find(1), '28-01-2017');
        }
        return Response::json($cargos) ;
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
                                             'shipCount'=>$shipCount,
                                            ]);
    }

    public function controlPanel(){
      return view('control_panel.terminal');
    }

}



