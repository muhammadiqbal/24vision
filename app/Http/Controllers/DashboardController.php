<?php

namespace App\Http\Controllers;

use App\DataTables\DashboardDataTable;
use App\Services\Calculator;
use App\Models\Cargo;
use App\Models\Ship;
use App\Models\Port;
use App\Models\Email;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DashboardDataTable $dashboardDataTable, Calculator $calculator)
    {
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

    public function execBCT(){
        $script = 'python3 ../PyTools/bulkcargotools/run.py ';
        $process = new Process($script);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        Flash::success($script.' executed with result: '.$process->getOutput());

        return redirect(url('/home'));
    }

}



