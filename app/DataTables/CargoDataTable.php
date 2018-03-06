<?php

namespace App\DataTables;

use App\Models\Cargo;
use Form;
use Yajra\DataTables\Services\DataTable;


class CargoDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->of($this->query())
            ->addColumn('action', 'cargos.datatables_actions')
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
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw("status like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('type', function($query, $keyword) {
                $query->whereRaw("type like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw("p1.name like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->whereRaw("p1.name like ?", ["%{$keyword}%"]);
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

        $cargos = Cargo::leftjoin('cargo_status', 'cargo_status.id','cargos.status_id')
                        ->leftjoin('cargo_types', 'cargos.cargo_type_id','cargo_types.id')
                        ->leftjoin('loading_discharging_rate_type as load_type', 'cargos.loading_rate_type','load_type.id')
                        ->leftjoin('loading_discharging_rate_type as disch_type', 'cargos.discharging_rate_type','disch_type.id')
                        ->leftjoin('ports as p1', 'p1.id','loading_port')
                        ->leftjoin('ports as p2', 'p2.id','discharging_port')
                        ->select('cargos.*','cargo_status.name as status','cargo_types.name as type', 'p1.name as load_port', 'p2.name as disch_port', 'load_type.name as l_type', 'disch_type.name as d_type');

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
            ->addAction(['width' => '20%'])
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
                //"defaultContent": "<i>Not set</i>",
                'initComplete' => "function () {
                            this.api().columns([10]).every(function () {
                                var column = this;
                                
                                $('#statusoption')
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
            
            'cargo_type_id' => ['defaultContent' => 'NULL','name' => 'type', 'data' => 'type', 'searchable'=> false],
            'quantity' => ['defaultContent' => 'NULL','name' => 'quantity', 'data' => 'quantity'],
            'loading_port' => ['defaultContent' => 'NULL', 'name' => 'load_port', 'data' => 'load_port', 'searchable'=> false],
            'discharging_port' => ['defaultContent' => 'NULL','name' => 'disch_port', 'data' => 'disch_port', 'searchable'=> false],
            'laycan_first_day' => ['defaultContent' => 'NULL','name' => 'laycan_first_day', 'data' => 'laycan_first_day'],
            'laycan_last_day' => ['defaultContent' => 'NULL','name' => 'laycan_last_day', 'data' => 'laycan_last_day'],
            'loading_rate' => ['defaultContent' => 'NULL','name' => 'loading_rate', 'data' => 'loading_rate'],
            'loading_rate_type' => ['defaultContent' => 'NULL','name' => 'l_type', 'data' => 'l_type', 'searchable'=> false],
            'discharging_rate'=>['defaultContent' => 'NULL','name' => 'discharging_rate', 'data' => 'discharging_rate'],
            'discharging_rate_type'=>['defaultContent' => 'NULL','name' => 'd_type', 'data' => 'd_type', 'searchable'=> false],
            'stowage_factor' => ['defaultContent' => 'NULL','name' => 'stowage_factor', 'data' => 'stowage_factor' ],
            'commission' => ['defaultContent' => 'NULL','name' => 'commission', 'data' => 'commission'],
            'email_id' => ['defaultContent' => 'NULL','name' => 'email_id', 'data' => 'email_id'],
            'status_id' => ['defaultContent' => 'NULL','name' => 'status', 'data' => 'status','searchable'=> false]
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
