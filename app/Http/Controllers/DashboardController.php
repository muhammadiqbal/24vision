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
use App\Models\Email;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use PhpImap\Mailbox;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use DB;
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

    public function testing()
    {
        $cargo = DB::table('cargos')->select(['cargos.*',
                                      'cargo_status.name as status',
                                      'cargo_types.name as type',
                                      'p1.name as load_port',
                                      'p2.name as disch_port',
                                      DB::raw('(quantity * 2) AS draft'),
                                      DB::raw('(cargos.quantity * cargo_types.stowage_factor) AS size')
                                    ])
                             ->leftjoin('cargo_status', 'cargos.status_id','cargo_status.id')
                             ->leftjoin('cargo_types', 'cargos.cargo_type_id','cargo_types.id')
                             ->leftjoin('ports as p1', 'p1.id','loading_port')
                             ->leftjoin('ports as p2', 'p2.id','discharging_port')
                             ->get();
        return Response::json(Email::orderBy('date','desc')->select('email.*'));
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

        $remainingSize = $selectedShip->max_holds_capacity - $occupied_size;     
        $remainingDraft = $selectedShip->max_laden_draft - $selectedShip->ballast_draft 
                            -(($occupied_tonage/$selectedShip->dwcc)*
                                ($selectedShip->max_laden_draft - $selectedShip->ballast_draft));
        $remainingTonnage = $selectedShip->dwcc-$occupied_tonage;

        $mailCount = Email::count();
        $cargoCount = Cargo::count();
        $shipCount = Ship::count();
        return $dashboardDataTable
                                  ->forRemainingTonnage($remainingTonnage)
                                  ->forRemainingSize($remainingSize)
                                  ->forRemainingDraft($remainingDraft)
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

    public function dashboard(Request $request)
    {
        $port = $request->input('port_id',Port::first()->id);
        $fuelType = $request->input('port_id',FuelType::first()->id);
        $bdi = $request->input('bdi',Bdi::first()->id);

        $feePriceChart = new Lavacharts; 
        $bdiPriceChart = new Lavacharts; 
        $fuelPriceChart = new Lavacharts; 

        $feePricedata = $feePriceChart->DataTable();
        $bdiPricedata = $bdiPriceChart->DataTable();
        $fuelPricedata = $fuelPriceChart->DataTable();

        $feePrices = FeePrice::select('start_date', 'price')
                              ->where('port_id', $port)
                              ->get();

        $fuelPrices = FuelPrice::select('start_date', 'price')
                              ->where('fuel_type_id', $fuelType)
                              ->get();

        $bdiPrices = BdiPrice::select('start_date', 'price')
                              ->where('bdi_id', $bdi)
                              ->get();

        $feePricedata->addDateColumn('Year')
                     ->addNumberColumn('Price');

        foreach ($feePrices as $feePrice) {
            $feePricedata->addRow([$feePrice->start_date, $feePrice->price]);
        }

        $fuelPricedata->addDateColumn('Year')
                     ->addNumberColumn('Price');

        foreach ($fuelPrices as $fuelPrice) {
            $fuelPricedata->addRow([$fuelPrice->start_date, $fuelPrice->price]);
        }

        $bdiPricedata->addDateColumn('Year')
                     ->addNumberColumn('Price');

        foreach ($bdiPrices as $bdiPrice) {
            $bdiPricedata->addRow([$bdiPrice->start_date, $bdiPrice->price]);
        }


        $feePriceChart->LineChart('feePricedata', $feePricedata, [
            'title' => 'Port fee Price ('.Port::find($port)->name.')',
            'legend' => [
                'position' => 'in'
            ]
        ]);

        $fuelPriceChart->LineChart('fuelPricedata', $fuelPricedata, [
            'title' => 'Fuel Price ('.FuelType::find($fuelType)->name.')',
            'legend' => [
                'position' => 'in'
            ]
        ]);

        $bdiPriceChart->LineChart('bdiPricedata', $bdiPricedata, [
            'title' => 'BDI Price ('.Bdi::find($bdi)->code.')',
            'legend' => [
                'position' => 'in'
            ]
        ]);

      return view('dashboard.index',compact('feePriceChart'));
                                    // ->with('feePriceChart', $feePriceChart)
                                    // ->with('fuelPriceChart', $fuelPriceChart)
                                    // ->with('bdiPriceChart', $bdiPriceChart);
    }

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
