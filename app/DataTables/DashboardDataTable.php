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
    protected $occupied_tonage;
    protected $occupied_size;
    protected $port;
    protected $date_of_opening;


    public function forShip(Ship $ship){
        $this->ship = $ship;
        return $this;
    }

    public function forOccSize($occupied_size){
        $this->occupied_size = $occupied_size;
        return $this;
    }

    public function forOccTonnage($occupied_tonage){
        $this->occupied_tonage = $occupied_tonage;
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




    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    { 

        return datatables()
            ->eloquent($this->query())
            // ->addColumn('bdi', function(Cargo $cargo){
            //     $ship = $this->ship;
            //         $port = $this->port;
            //         $date_of_opening = $this->date_of_opening;
            //     return view('calculator.bdi', 
            //             compact('cargo','ship','port','date_of_opening'))->render();
            // })
            ->addColumn('action', function(Cargo $cargo) {
                    $ship = $this->ship;
                    $port = $this->port;
                    $date_of_opening = $this->date_of_opening;

                    return view('calculator.datatables_actions', 
                        compact('cargo','ship','port','date_of_opening'))->render();
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
                    return '<b style=\'color:red;\'>'.$cargo->loading_port.'</b>';
                }
            })
             ->editColumn('loading_port',function(Cargo $cargo){
                if ($cargo->loading_port_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->loading_port.'</b>';
                }
            })
             ->editColumn('discharge_port',function(Cargo $cargo){
                if ($cargo->cargo_type_id_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->cargo_type_id.'</b>';
                }
            })
            ->editColumn('discharge_port',function(Cargo $cargo){
                if ($cargo->stowage_factor_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->stowage_factor.'</b>';
                }
            })
            ->editColumn('discharge_port',function(Cargo $cargo){
                if ($cargo->quantity_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->quantity.'</b>';
                }
            })
            ->editColumn('discharge_port',function(Cargo $cargo){
                if ($cargo->loading_rate_type_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->loading_rate_type.'</b>';
                }
            })
            ->editColumn('discharge_port',function(Cargo $cargo){
                if ($cargo->loading_rate_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->loading_rate.'</b>';
                }
            })
            ->editColumn('discharge_port',function(Cargo $cargo){
                if ($cargo->discharging_rate_type_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->discharging_rate_type.'</b>';
                }
            })
            ->editColumn('discharge_port',function(Cargo $cargo){
                if ($cargo->discharging_rate_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->discharging_rate_.'</b>';
                }
            })
            ->editColumn('discharge_port',function(Cargo $cargo){
                if ($cargo->commision_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->commision.'</b>';
                }
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $cargos = Cargo::leftjoin('cargo_status', 'cargo_status.id','cargo_status.id')
                        ->leftjoin('cargo_types', 'cargos.cargo_type_id','cargo_types.id')
                        ->leftjoin('ports as p1', 'p1.id','loading_port')
                        ->leftjoin('ports as p2', 'p2.id','discharging_port')
                        ->where('quantity','<=', ($this->ship->dwcc - $this->occupied_tonage))
                        // ->where(DB::raw('quantity * stowage_factor AS size'),
                        //                 '<=',
                        //                 ($this->ship->max_holds_capacity - $this->occupied_size))
                        // ->where(DB::raw('quantity *'.$this->ship->ballast_draft),
                        //                 '<=', 
                        //                 ($this->ship->max_laden_draft-($this->ship->ballast_draft * $this->occupied_tonage)))
                        ->select('cargos.*','cargo_status.name as status','cargo_types.name as type', 'p1.name as load_port', 'p2.name as disch_port');
                        if($this->request()->get('port_id')){
                            $cargos->where('loading_port',$this->request()->get('port_id'));
                        }
                        if($this->request()->get('date_of_opening')){
                            $cargos->whereDate('laycan_first_day','>=',date($this->request()->get('date_of_opening')))
                                   ->whereDate('laycan_last_day','<=',date($this->request()->get('date_of_opening')));
                        }

        foreach ($cargos as $cargo) {
            $cargo->setBdi($this->port,$this->ship, $this->date_of_opening);
        }
                        
        return $this->applyScopes($cargos);
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
            ->addAction(['width' => '10%'])
            ->addColumn(['defaultContent' => '',
                        'data' => $cargo->setBdi($port, $ship,$date_of_opening),
                        'name' => 'bdi',
                        'title' => 'bdi'
                        ])
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
                'initComplete' => "function () {
                            this.api().columns().every(function () {
                                var column = this;
                                var input = document.createElement(\"input\");
                                $(input).appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }",
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
            'cargo_type_id' => ['defaultContent' => 'NULL','name' => 'type', 'data' => 'type'],
            'quantity' => ['defaultContent' => 'NULL','name' => 'quantity', 'data' => 'quantity'],
            'laycan_first_day' => ['defaultContent' => 'NULL','name' => 'laycan_first_day', 'data' => 'laycan_first_day'],
            'laycan_last_day' => ['defaultContent' => 'NULL','name' => 'laycan_last_day', 'data' => 'laycan_last_day'],
            'loading_port' => ['defaultContent' => 'NULL','name' => 'load_port', 'data' => 'load_port'],
            'discharging_port' => ['defaultContent' => 'NULL','name' => 'disch_port', 'data' => 'disch_port'],
            'email_id' => ['defaultContent' => 'NULL','name' => 'email_id', 'data' => 'email_id'],
            'bdi' => ['defaultContent'=>'NULL', 'name'=>'bdi', 'data'=>'bdi'],
            'ntce' => ['defaultContent'=>'NULL', 'name'=>'', 'data'=>''],
            'gross_rate' => ['defaultContent'=>'NULL', 'name'=>'', 'data'=>''],
            'status_id' => ['defaultContent' => 'NULL','name' => 'status', 'data' => 'status'],
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
