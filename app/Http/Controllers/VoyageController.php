<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ship;
use App\Models\Cargo;
use App\Models\Port;
use App\Models\Date;
 

class VoyageController extends Controller
{
    //

    function getVoyage(Ship $ship, Cargo $cargo, Port $port_ship,Date $date){


    	return view('voyages.index');
    }
}
