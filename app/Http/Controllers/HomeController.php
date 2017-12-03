<?php

namespace App\Http\Controllers;

use Mapper;
use App\Models\Port;
use App\Models\ShipPosition;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Route;

class HomeController extends Controller
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
          $ports = Port::all();
                //$items = Item::distance(0.1,'45.05,7.6667')->get();
 
        // return view('home')->with(['ports'=>$ports]);
         Mapper::map($ports[0]->location,$ports[0]->location);

        foreach($ports as $port){
            if($port->cargo != null)
                $cargo = $port->cargo->count();
            else $cargo =0;
            if($port->ships != null)
                $ships = $port->ships->count();
            else $ships = 0;

            Mapper::marker($port->location,$port->location,['eventMouseOver' => '', 'eventClick' => 'window.location = \''.url('ports/'.$port->id).'\';', 'title'=> $port->name.' cargo='.$cargo.', ships='.$ships,'label'=> $port->name.',Cargo='.$cargo.'; Ships='.$ships]);
            if($port==$ports[20])
                break;
    }
        
    return view('map')->with(['ports'=>$ports]);
    }


    public function openPosition($port){
        $cargos = Cargo::where('port_id',$port);
        $shipPositions = ShipPosition::where('port_id',$port);

        return view('cargos.index')->with('cargos', $cargos)
                                   ->with('shipPositions',$shipPositions);

    }
}
