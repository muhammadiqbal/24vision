<?php
namespace App\Http\Controllers;

use App\DataTables\DashboardDataTable;
use App\Services\Calculator;
use App\Models\Cargo;
use App\Models\FeePrice;
use App\Models\FuelPrice;
use App\Models\FuelType;
use App\Models\BdiPrice;
use App\Models\Bdi;
use App\Models\Ship;
use App\Models\Port;
use App\Models\Zone;
use App\Models\Email;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use \League\Geotools\Polygon\Polygon;
use \League\Geotools\Coordinate\Coordinate;
use Illuminate\Http\Request;
use PhpImap\Mailbox;
use DB;
use Flash;
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

    public function assignPortToZone(Request $request)
    {


      /**port zone assignment**/
      $ports = Port::all();
      $zones = Zone::all();
      $count = 0;

      foreach ($ports as $port) {
        if ($port->zone_id ==null){
          foreach ($zones as $zone) {
            $zonePoints = $zone->zonePoints;
            $polyCoordinate = array();
            foreach ($zonePoints as $zonePoint) {
              array_push($polyCoordinate, [$zonePoint->latitude, $zonePoint->longitude]);
            }
            $polygon = new Polygon($polyCoordinate);

            if ($port->latitude && $port->longitude && $polygon->pointInPolygon(new Coordinate([$port->latitude, $port->longitude]))) {
             $port->update(['zone_id'=>$zone->id]);
             break;
           }
         }
       }
     }
     Flash::success('Port assigned to Zone');

     return redirect(url('/home'));
     /**END of Port zone assignment**/
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

      $mailCount = Email::count();
      $cargoCount = Cargo::count();
      $shipCount = Ship::count();
      $remainingSize = 0;     
      $allowedDraft = 0;
      $occupied_draft = 0;
      $remainingDraft = 0;
      $remainingTonnage = 0;

      $range = $request->input('range',0);
      $occupied_size = $request->input('occupied_size',0);
      $occupied_tonage = $request->input('occupied_tonage',0);
      $date_of_opening = $request->input('date_of_opening',date('d-m-Y'));
      $range = $request->input('range')? $request->input('range'):0;

      if(!$request->input('ship_id') && !$request->input('port_id')){
        return view('calculator.index_empty',compact('ships', 
         'ports',
         'occupied_size',
         'occupied_tonage',
         'occupied_draft' ,
         'allowedDraft' ,
         'remainingDraft',
         'date_of_opening',
         'mailCount',
         'cargoCount',
         'shipCount',
         'range'));
      }

      if($request->input('ship_id')){
       $selectedShip = Ship::find($request->input('ship_id'));
     }

     if($request->input('port_id')){
       $port = Port::find($request->input('port_id'));;
     }

     if($selectedShip && $port){
      $remainingSize = $selectedShip->max_holds_capacity - $occupied_size;     
      $allowedDraft = $selectedShip->max_laden_draft - $selectedShip->ballast_draft;
      $occupied_draft = round(round(($occupied_tonage/$selectedShip->dwcc),2)*$allowedDraft,2);
      $remainingDraft = $allowedDraft - round($occupied_draft,2);
      $remainingTonnage = $selectedShip->dwcc-$occupied_tonage;
    }


    return $dashboardDataTable->forRemainingTonnage($remainingTonnage)
                              ->forRemainingSize($remainingSize)
                              ->forRemainingDraft($remainingDraft)
                              ->forShip($selectedShip)
                              ->forPort($port)
                              ->forDateOfOpening($date_of_opening)
                              ->forRange($range)
                              ->render('calculator.index',
                                        ['ships'=>$ships, 
                                        'ports'=>$ports,
                                        'selectedShip'=>$selectedShip,
                                        'occupied_size'=>$occupied_size,
                                        'occupied_tonage'=>$occupied_tonage,
                                        'occupied_draft' =>$occupied_draft,
                                        'allowedDraft' => $allowedDraft,
                                        'remainingDraft' => $remainingDraft,
                                        'date_of_opening'=>$date_of_opening,
                                        'mailCount'=>$mailCount,
                                        'cargoCount'=>$cargoCount,
                                        'shipCount'=>$shipCount,
                                        'range'=>$range,
                                        'selectedPort'=>$port
                                        ]);
  }

  public function linechart(Request $request)
  {
    $entity = $request->input('entity','bdi'); 

    $port_id = $request->input('port',Port::first()->id);
    $fuel_type_id = $request->input('FuelType',FuelType::first()->id);
    $bdi_id = $request->input('bdi',Bdi::first()->id);

    if($entity == 'feePrice'){
      $data = FeePrice::select(DB::raw('DATE(start_date) as Date'), 'price as Price')
      ->where('port_id', $port_id)
      ->get()
      ->toJson();
      $title = "Port ".Port::find($port_id)->name.' Fees';
    }elseif ($entity == 'fuelPrice') {
      $data = FuelPrice::select(DB::raw('DATE(start_date) as Date'), 'price as Price')
      ->where('fuel_type_id', $fuel_type_id)
      ->get()
      ->toJson();
      $title = "Fuel Type ".FuelType::find($fuel_type_id)->name.' Price';
    }elseif ($entity == 'bdiPrice') {
      $data = BdiPrice::select(DB::raw('DATE(start_date) as Date'), 'price as Price')
      ->where('bdi_id', $bdi_id)
      ->get()
      ->toJson();
      $title = "BDI ".Bdi::find($bdi_id)->name.' Price';
    }

    return view('chart.line')->with('data', $data)
    ->with('title',$title);
  }

  public function cargoMap(){
    $cargos = Cargo::select(DB::raw('COUNT(cargos.id) as count'),
                                    'lPort.longitude as lPortLongitude',
                                    'lPort.latitude as lPortLatitude',
                                    'dPort.longitude as dPortLongitude',
                                    'dPort.latitude as dPortLatitude',
                                    'lPort.name as port')
                                    ->leftjoin('ports as lPort','loading_port','lPort.id')
                                    ->leftjoin('ports as dPort','discharging_port','dPort.id')
                                    ->whereNotNull('loading_port')
                                    ->whereNotNull('discharging_port')
                                    ->groupBy('loading_port')
                                    ->groupBy('discharging_port')
                                    ->get()->toJson();
    return view('chart.map')->with('cargos',$cargos);
  }

  /* this function is to execute bulkcargo Tools using PHP scipt*/
  /* be careful executing shell command. Mind the user privilege and the execution environment*/
  /* temporarily has to be disabled*/
    /*
    public function execBCT()
    {

        //read Imap config from .env file
        $hostname = env('IMAP_HOST', '{outlook.office365.com}Test_IMAP');
        $username = env('IMAP_USERNAME', 'MunsterUniversity@24Vision.Solutions');
        $password = env('IMAP_PASSWORD', 'Yoz39332');

        //$inboxprefix = "24VisionChartering-";

        $mailbox = new Mailbox($hostname, $username, $password, __DIR__);
        $mailsIds = $mailbox->searchMailbox('ALL');
        if(!$mailsIds) {
            $request->session()->flash('error', 'mailbox is empty!');
        }

        $emails = $mailbox->getMailsInfo($mailsIds);
        $saveCount = 0;
    
        foreach ($emails as $email) {
            $input = ['subject'=> @$email->subject,
                    'body'=> quoted_printable_decode(@$mailbox->getMail($email->uid,false)->textPlain),
                    'sender'=> @$email->from,
                    'receiver'=> @$email->to,
                    'cc'=> @$email->cc,
                    'classification_manual'=>null,
                    'date'=> \Carbon\Carbon::parse(@$email->date),
                    'classification_automated'=>null,
                    'IMAPUID'=> $email->uid,
                    'IMAPFolderID'=>null,
                    '_created_on'=>date('Y-m-d'),
                    'classification_automated_certainty'=>null,
                    'kibana_extracted'=>false];
            if(Email::where('IMAPUID',$email->uid)->first() == null){
                $storeEmail = $emailRepo->create($input);
                if ($storeEmail) {
                    $saveCount++;
                }
            }

        }

        $script = 'export LD_LIBRARY_PATH=/lib:/$USER/lib:/$USER/.local/lib/python3.5/site-packages && python3 ../PyTools/bulkcargotools/run.py ';
        $process = new Process($script);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        Flash::success($script.' executed with result: '.$process->getOutput());

        return redirect(url('/home'));
     }
     */
     /** ENd OF ExecBCT funcion **/
   }
