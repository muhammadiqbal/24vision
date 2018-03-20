<?php
namespace App\DataTables;
use App\Models\Cargo;
use App\Models\Ship;
use App\Models\Port;
use Yajra\DataTables\Services\DataTable;
use DB;


class DashboardDataTable extends DataTable
{
    protected $ship;
    protected $remaining_tonage;
    protected $remaining_size;
    protected $remaining_draft;
    protected $port;
    protected $date_of_opening;
    protected $null = '<b style=\'color:blue;\'>NULL</b>';
    protected $range;

    public function forShip(Ship $ship){
        $this->ship = $ship;
        return $this;
    }
    public function forRemainingSize($remaining_size){
        $this->remaining_size = $remaining_size;
        return $this;
    }
    public function forRemainingTonnage($remaining_tonage){
        $this->remaining_tonage = $remaining_tonage;
        return $this;
    }
    public function forPort(Port $port){
        $this->port = $port;
        return $this;
    }
    public function forDateOfOpening($dop){
        $this->date_of_opening = $dop;
        return $this;
    }
    public function forRemainingDraft($remaining_draft){
        $this->remaining_draft = $remaining_draft;
        return $this;
    }  
    public function forRange($range){
        $this->range = $range;
        return $this;
    }  

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    { 
        return datatables()
            ->of($this->query()) //change this to collection apply the bdi set in query
            ->addColumn('action', function(Cargo $cargo) {
                    $ship = $this->ship;
                    $port = $this->port;
                    $date_of_opening = $this->date_of_opening;
                    return view('calculator.datatables_actions', 
                        compact('cargo','ship','port','date_of_opening'))->render();
            })
            ->editColumn('bdi', function(Cargo $cargo){
                $ship = $this->ship;
                $port = $this->port;
                $date_of_opening = $this->date_of_opening;

                return '$'.round($cargo->setBdi($port, $ship, $date_of_opening),2);
            })
            ->addColumn('ntce', function(Cargo $cargo){
                $ship = $this->ship;
                $port = $this->port;
                $date_of_opening = $this->date_of_opening;

                return '$'.round($cargo->setNtce($port, $ship, $date_of_opening),2);
            })
            ->addColumn('gross_rate', function(Cargo $cargo){
                $ship = $this->ship;
                $port = $this->port;
                $date_of_opening = $this->date_of_opening;

                return '$'.round($cargo->setGrossRate($port, $ship, $date_of_opening),2);
            })
            ->editColumn('cargo_type_id', function(Cargo $cargo){
                if ($cargo->cargo_type_id_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->type.'</b>';
                } else {                
                    return $cargo->type;
                }               
            })
            ->editColumn('quantity', function(Cargo $cargo){
                if ($cargo->quantity_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->quantity.'</b>';
                }elseif ($cargo->quantity_constructed) {
                    return '<b style=\'color:green;\'>'.$cargo->quantity.'</b>';
                } else {                
                    return $cargo->quantity;
                }               
            })
           ->editColumn('laycan_first_day', function(Cargo $cargo){
                if ($cargo->laycan_first_day == null){
                    return null;
                }elseif($cargo->laycan_first_day_manual) {
                    return '<b style=\'color:red;\'>'.date('d-m-Y',strtotime($cargo->laycan_first_day)).'</b>';
                }elseif ($cargo->laycan_first_day_constructed) {
                    return '<b style=\'color:green;\'>'.date('d-m-Y',strtotime($cargo->laycan_first_day)).'</b>';
                }else {                
                    return date('d-m-Y',strtotime($cargo->laycan_first_day));
                }               
            })
            ->editColumn('laycan_last_day', function(Cargo $cargo){
                if ($cargo->laycan_last_day == null){
                    return null;
                }elseif($cargo->laycan_last_day_manual) {
                    return '<b style=\'color:red;\'>'.date('d-m-Y',strtotime($cargo->laycan_last_day)).'</b>';
                } elseif ($cargo->laycan_last_day_constructed) {
                    return '<b style=\'color:green;\'>'.date('d-m-Y',strtotime($cargo->laycan_last_day)).'</b>';
                } else {                
                    return date('d-m-Y',strtotime($cargo->laycan_last_day));
                }
            })
            ->editColumn('loading_port',function(Cargo $cargo){
                if ($cargo->loading_port_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->load_port.'</b>';
                }else{
                    return $cargo->load_port;
                }
            })
            ->editColumn('discharging_port',function(Cargo $cargo){
                if ($cargo->discharging_port_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->disch_port.'</b>';
                }else{
                    return $cargo->disch_port;
                }
            })
            ->rawColumns(['action','cargo_type_id', 'quantity','laycan_first_day','laycan_last_day','loading_port','discharging_port'])
            ->make(true);
    }
    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

        $cargo = Cargo::select(['cargos.*',
                                      'cargo_status.name as status',
                                      'cargo_types.name as type',
                                      'p1.name as load_port',
                                      'p2.name as disch_port',
                                      DB::raw('(quantity / '.$this->ship->dwcc.')*'.$this->ship->max_laden_draft - $this->ship->ballast_draft.' AS draft'),
                                      DB::raw('quantity * cargo_types.stowage_factor AS size'),
                                      DB::raw('ST_Distance(POINT('.$this->port->latitude.','.$this->port->longitude.'), POINT(p1.latitude,p1.longitude)) AS \'ranges\'' )
                                    ])
                            ->leftjoin('cargo_status', 'cargos.status_id','cargo_status.id')
                            ->leftjoin('cargo_types', 'cargos.cargo_type_id','cargo_types.id')
                            ->leftjoin('ports as p1', 'p1.id','loading_port')
                            ->leftjoin('ports as p2', 'p2.id','discharging_port')
                            ->where('quantity','<=', $this->remaining_tonage)
                            ->whereNotNull('loading_port')
                            ->having('size','<=',$this->remaining_size)
                            ->having('draft','<=',$this->remaining_draft)
                            ->havingRaw('(\'ranges\' <='.$this->range.' or loading_port ='.$this->port->id.')');
 
        if($this->request()->get('cargo_status')){
            $cargo->whereIn('cargos.status_id', $this->request()->get('cargo_status'));
        }
        if($this->request()->get('date_of_opening')){
            $cargo->where(function($q){
                $q->whereDate('laycan_first_day','<=',$this->request()->get('date_of_opening'));
                $q->orWhere(function($q){
                    $q->whereDate('laycan_first_day','<=',$this->request()->get('date_of_opening'));
                    $q->whereNull('laycan_last_day');
                });
            });
        }
        return $this->applyScopes($cargo);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '15%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => true,
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             'csv',
                             'excel',
                             'pdf',
                         ],
                    ],
                    'colvis'
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'cargo_type_id' => ['defaultContent' => $this->null,'name' => 'type', 'data' => 'type','title'=>'cargo_type_id','searchable'=> false],
            'quantity' => ['defaultContent' => $this->null,'name' => 'quantity', 'data' => 'quantity','title'=>'quantity'],
            'laycan_first_day' => ['defaultContent' => $this->null,'name' => 'laycan_first_day', 'data' => 'laycan_first_day','title'=>'laycan_first_day'],
            'laycan_last_day' => ['defaultContent' => $this->null,'name' => 'laycan_last_day', 'data' => 'laycan_last_day','title'=>'laycan_last_day'],
            'loading_port' => ['defaultContent' => $this->null,'name' => 'load_port', 'data' => 'load_port','title'=>'loading_port','searchable'=> false],
            'discharging_port' => ['defaultContent' => $this->null,'name' => 'disch_port', 'data' => 'disch_port','title'=>'discharging_port','searchable'=> false],
            'email_id' => ['defaultContent' => $this->null,'name' => 'email_id', 'data' => 'email_id','title'=>'email_id'],
            'bdi' => ['defaultContent'=>$this->null, 'name'=>'bdi', 'data'=>'bdi', 'title'=>'bdi','title'=>'bdi'],
            'ntce' => ['defaultContent'=>$this->null, 'name'=>'', 'data'=>'ntce',  'title'=>'ntce','title'=>'ntce'],
            'gross_rate' => ['defaultContent'=>$this->null, 'name'=>'', 'data'=>'gross_rate', 'title'=>'gross_rate','title'=>'gross_rate'],
            'status_id' => ['defaultContent' => $this->null,'name' => 'status', 'data' => 'status','title'=>'status_id','searchable'=> false],
            'range' => ['defaultContent'=>$this->null, 'name'=>'ranges', 'data'=>'ranges', 'title'=>'ranges'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'cargos';
    }
}