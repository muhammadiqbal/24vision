<?php
namespace App\DataTables;
use App\Models\Cargo;
use App\Models\Ship;
use App\Models\Port;
use Yajra\DataTables\Services\DataTable;
use \League\Geotools\Geotools;
use \League\Geotools\Coordinate\Coordinate;
use App\Services\Calculator;
class DashboardDataTable extends DataTable
{
    protected $ship;
    protected $remaining_tonage;
    protected $remaining_size;
    protected $remaining_draft;
    protected $port;
    protected $date_of_opening;

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

                return $cargo->setBdi($port, $ship, $date_of_opening);
            })
            ->addColumn('ntce', function(Cargo $cargo){
                $ship = $this->ship;
                $port = $this->port;
                $date_of_opening = $this->date_of_opening;

                return $cargo->setNtce($port, $ship, $date_of_opening);
            })
            ->addColumn('gross_rate', function(Cargo $cargo){
                $ship = $this->ship;
                $port = $this->port;
                $date_of_opening = $this->date_of_opening;

                return $cargo->setGrossRate($port, $ship, $date_of_opening);
            })
            ->editColumn('cargo_type_id', function(Cargo $cargo){
                if ($cargo->laycan_first_day_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->type.'</b>';
                } else {                
                    return $cargo->type;
                }               
            })
            ->editColumn('quantity', function(Cargo $cargo){
                if ($cargo->quantity_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->quantity.'</b>';
                } else {                
                    return $cargo->quantity;
                }               
            })
            ->editColumn('laycan_first_day', function(Cargo $cargo){
                if ($cargo->laycan_first_day_manual) {
                    return '<b style=\'color:red;\'>'.date_format(date_create($cargo->laycan_first_day),'d-m-Y').'</b>';
                } else {                
                    return date_format(date_create($cargo->laycan_first_day),'d-m-Y');
                }               
            })
            ->editColumn('laycan_last_day', function(Cargo $cargo){
                if ($cargo->laycan_last_day_manual) {
                    return '<b style=\'color:red;\'>'.date_format(date_create($cargo->laycan_last_day),'d-m-Y').'</b>';
                } else {                
                    return date_format(date_create($cargo->laycan_last_day),'d-m-Y');
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
            ->rawColumns(['cargo_type_id', 'quantity','laycan_first_day','laycan_last_day','loading_port','discharging_port'])
            //->filterColumn('status', 'whereRaw', "?", ["$1"])
            ->make(true);
    }
    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $cargo = Cargo::leftjoin('cargo_status', 'cargo_status.id','cargo_status.id')
                        ->leftjoin('cargo_types', 'cargos.cargo_type_id','cargo_types.id')
                        ->leftjoin('ports as p1', 'p1.id','loading_port')
                        ->leftjoin('ports as p2', 'p2.id','discharging_port')
                        ->select('cargos.*',
                                 'cargo_status.name as status',
                                 'cargo_types.name as type',
                                 'p1.name as load_port',
                                 'p2.name as disch_port'
                                )
                        ->where('loading_port',$this->port->id)
                        ->where('quantity','<=',  $this->remaining_tonage)
                        //->having('quantity * stowage_factor','<=',$this->remaining_size)
                        //->having(DB::raw('quantity * '.$this->ship->ballast_draft.' as draft'),'<=',$this->remaining_draft)
                        //ST_Distance_Sphere() only supported in mysql 5.7
                        // ->havingRaw('ST_Distance_Sphere(ST_GeomFromText(POINT($port->latitude $port->longitude), ST_GeomFromText(POINT(latitude longitude))',<= $this->request()->get('radius'))
                        ;
        if($this->request()->get('cargo_status')){
            $cargo->where('cargos.status_id', $this->request()->get('cargo_status'));
        }
        if($this->request->get('date_of_opening')){
            $cargo->whereDate('laycan_first_day','>=',date($this->request()->get('date_of_opening')))
                  ->whereDate('laycan_last_day','<=',date($this->request()->get('date_of_opening')));

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
            'cargo_type_id' => ['defaultContent' => 'NULL','name' => 'type', 'data' => 'type','title'=>'cargo_type_id'],
            'quantity' => ['defaultContent' => 'NULL','name' => 'quantity', 'data' => 'quantity','title'=>'quantity'],
            'laycan_first_day' => ['defaultContent' => 'NULL','name' => 'laycan_first_day', 'data' => 'laycan_first_day','title'=>'laycan_first_day'],
            'laycan_last_day' => ['defaultContent' => 'NULL','name' => 'laycan_last_day', 'data' => 'laycan_last_day','title'=>'laycan_last_day'],
            'loading_port' => ['defaultContent' => 'NULL','name' => 'load_port', 'data' => 'load_port','title'=>'loading_port'],
            'discharging_port' => ['defaultContent' => 'NULL','name' => 'disch_port', 'data' => 'disch_port','title'=>'discharging_port'],
            'email_id' => ['defaultContent' => 'NULL','name' => 'email_id', 'data' => 'email_id','title'=>'email_id'],
            'bdi' => ['defaultContent'=>'NULL', 'name'=>'bdi', 'data'=>'bdi', 'title'=>'bdi','title'=>'bdi'],
            'ntce' => ['defaultContent'=>'NULL', 'name'=>'', 'data'=>'ntce',  'title'=>'ntce','title'=>'ntce'],
            'gross_rate' => ['defaultContent'=>'NULL', 'name'=>'', 'data'=>'gross_rate', 'title'=>'gross_rate','title'=>'gross_rate'],
            'status_id' => ['defaultContent' => 'NULL','name' => 'status', 'data' => 'status','title'=>'status_id'],
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