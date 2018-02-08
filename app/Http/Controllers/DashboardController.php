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
         $range = $request->input('range');

         $mailCount = Email::count();
         //$mailCount =($selectedShip->max_laden_draft/$selectedShip->ballast_draft) -$occupied_tonage;
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
                                             'range'=>$range,
                                             'selectedPort'=>$port
                                            ]);
    }

    public function controlPanel(){
      return view('control_panel.terminal');
    }

}



