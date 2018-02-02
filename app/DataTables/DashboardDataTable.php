<?php

namespace App\DataTables;

use App\Models\Cargo;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use \League\Geotools\Geotools;
use \League\Geotools\Coordinate\Coordinate;

class DashboardDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    { 

        return datatables()
            ->eloquent($this->query())
            // ->addColumn('distance_to_start',function(Cargo $cargo){
            //     return ;
            // })
            // ->addColumn('route',function(Cargo $cargo){
            //     return ;
            // })
            // ->addColumn('bdi',function(Cargo $cargo){
            //     $bdi_id = $calculator->calculateBDIId($port_ship,$cargo);
            //     $bdi = $calculator->calculateBDI($bdi_id, $date, $travel_time_to_start);
            //     return ;
            // })
            // ->addColumn('gross_rate',function(Cargo $cargo){
            //     $gross_rate = $calculator->calculateGrossRate($cargo, $bdi, $voyage_time_bdi, $non_hire_costs_bdi);
            //     return ;
            // })
            // ->addColumn('ntce',function(Cargo $cargo){
            //     $ntce = $calculator->calculateNTCE($cargo, $bdi, $voyage_time, $non_hire_costs, $gross_rate);
            //     return ;
            // })
            ->addColumn('action', 'calculator.datatables_actions')
            ->editColumn('laycan_first_day', function(Cargo $cargo){
               return date_format(date_create($cargo->laycan_first_day),'d-m-Y');
            })
            ->editColumn('laycan_last_day', function(Cargo $cargo){
               return date_format(date_create($cargo->laycan_last_day),'d-m-Y');
            })
            ->editColumn('loading_port',function(Cargo $cargo){
                if ($cargo->loading_port_manual) {
                    return '<b style=\'color:red;\'>'.$cargo->loading_port_manual.'</b>';
                }
            })
            ->make(true)
              ;
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
                        ->select('cargos.*','cargo_status.name as status','cargo_types.name as type', 'p1.name as load_port', 'p2.name as disch_port');
        if ($this->request()->get('port_id')) {
            $cargos->where('loading_port',$this->request()->get('port_id'));
        }
        if ($this->request()->get('date_of_opening')) {
            $cargos->whereDate('laycan_first_day','>=',date($this->request()->get('date_of_opening')))
                  ->whereDate('laycan_last_day','<=',date($this->request()->get('date_of_opening')));
        }
        // if ($this->request()->get('range')) {
        //     $cargos->where('',$ship);
        // }
        // if ($this->request()->get('occupied_size')) {
        //     $cargos->where('',$this->request()->get('occupied_size'));
        // }
        // if ($this->request()->get('occupied_tonnage')) {
        //     $cargos->where('',$this->request()->get('occupied_tonnage')-$ship->dwcc);
        // }
        // if ($this->request()->get('current_draft')) {
        //     $cargos->where('',$this->request()->get('current_draft'));
        // }

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
