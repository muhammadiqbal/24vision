<?php

namespace App\Http\Controllers;

use App\DataTables\DashboardDataTable;
use App\Services\Calculator;
use App\Models\Cargo;
use App\Models\Ship;
use App\Models\Port;
use App\Models\Email;
use Illuminate\Http\Request;
use PhpImap\Mailbox;
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
        $hostname = '{outlook.office365.com}Test_IMAP';
        $username = 'MunsterUniversity@24Vision.Solutions';
        $password = 'Yoz39332';
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
