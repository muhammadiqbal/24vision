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
            ->eloquent($this->query())
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
                        ->select('cargos.*','cargo_status.name as status','cargo_types.name as type', 'p1.name as load_port', 'p2.name as disch_port');
        //->with('loading_port')->with('discharging_port')->with('cargoType')->with('cargoStatus');

        foreach ($cargos as $cargo) {
            $bdi = Bdi::find(1);
            
            $grossRate = $this->calculateGrossRate($cargo, $shipPositionGrossRate, 226, $bdi->price);

            $ntce = $this->calculateNTCE($cargo, $shipPosition,226, $grossRate);

            $route = Route::where('area1',$cargo->loading_port)
                          ->where('area3',$cargo->discharging_port)
                          ->first();
            if($route == null){
                $route = Route::find(1);
            }
            
            $cargo->setRoute($ntce);
            $cargo->setBdi($bdi->price);
            $cargo->setGrossRate($grossRate);
            $cargo->setNtce($ntce);
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
            
            'loading_port' => ['defaultContent' => 'NULL', 'name' => 'load_port', 'data' => 'load_port'],
            //'loading_port_manual' => ['name' => 'loading_port_manual', 'data' => 'loading_port_manual'],
            'discharging_port' => ['defaultContent' => 'NULL','name' => 'disch_port', 'data' => 'disch_port'],
            //'discharging_port_manual' => ['name' => 'discharging_port_manual', 'data' => 'discharging_port_manual'],
            'laycan_first_day' => ['defaultContent' => 'NULL','name' => 'laycan_first_day', 'data' => 'laycan_first_day'],
            //'laycan_first_day_manual' => ['name' => 'laycan_first_day_manual', 'data' => 'laycan_first_day_manual'],
            //'laycan_first_day_constructed' => ['name' => 'laycan_first_day_constructed', 'data' => 'laycan_first_day_constructed'],
            'laycan_last_day' => ['defaultContent' => 'NULL','name' => 'laycan_last_day', 'data' => 'laycan_last_day'],
            //'laycan_last_day_manual' => ['name' => 'laycan_last_day_manual', 'data' => 'laycan_last_day_manual'],
            //'laycan_last_day_constructed' => ['name' => 'laycan_last_day_constructed', 'data' => 'laycan_last_day_constructed'],
            'cargo_type_id' => ['defaultContent' => 'NULL','name' => 'type', 'data' => 'type'],
            //'cargo_type_id_manual' => ['name' => 'cargo_type_id_manual', 'data' => 'cargo_type_id_manual'],
            'stowage_factor' => ['defaultContent' => 'NULL','name' => 'stowage_factor', 'data' => 'stowage_factor'],
            //'stowage_factor_manual' => ['name' => 'stowage_factor_manual', 'data' => 'stowage_factor_manual'],
            //'stowage_factor_constructed' => ['name' => 'stowage_factor_constructed', 'data' => 'stowage_factor_constructed'],
            //'sf_unit' => ['name' => 'sf_unit', 'data' => 'sf_unit'],
            //'ship_specialization_id' => ['name' => 'ship_specialization_id', 'data' => 'ship_specialization_id'],
            //'quantity_measurement_id' => ['name' => 'quantity_measurement_id', 'data' => 'quantity_measurement_id'],
            'quantity' => ['defaultContent' => 'NULL','name' => 'quantity', 'data' => 'quantity'],
            //'quantity_manual' => ['name' => 'quantity_manual', 'data' => 'quantity_manual'],
            //'quantity_constructed' => ['name' => 'quantity_constructed', 'data' => 'quantity_constructed'],
            //'loading_rate_type' => ['name' => 'loading_rate_type', 'data' => 'loading_rate_type'],
            //'loading_rate_type_manual' => ['name' => 'loading_rate_type_manual', 'data' => 'loading_rate_type_manual'],
            'loading_rate' => ['defaultContent' => 'NULL','name' => 'loading_rate', 'data' => 'loading_rate'],
            //'loading_rate_manual' => ['name' => 'loading_rate_manual', 'data' => 'loading_rate_manual'],
            //'loading_rate_constructed' => ['name' => 'loading_rate_constructed', 'data' => 'loading_rate_constructed'],
            //'discharging_rate_type' => ['name' => 'discharging_rate_type', 'data' => 'discharging_rate_type'],
            //'discharging_rate_type_manual' => ['name' => 'discharging_rate_type_manual', 'data' => 'discharging_rate_type_manual'],
            //'discharging_rate' => ['name' => 'discharging_rate', 'data' => 'discharging_rate'],
            //'discharging_rate_manual' => ['name' => 'discharging_rate_manual', 'data' => 'discharging_rate_manual'],
            //'discharging_rate_constructed' => ['name' => 'discharging_rate_constructed', 'data' => 'discharging_rate_constructed'],
            //'extra_condition' => ['name' => 'extra_condition', 'data' => 'extra_condition'],
            'commission' => ['defaultContent' => 'NULL','name' => 'commission', 'data' => 'commission'],
            //'commision_manual' => ['name' => 'commision_manual', 'data' => 'commision_manual'],
            //'commision_constructed' => ['name' => 'commision_constructed', 'data' => 'commision_constructed'],
            'email_id' => ['defaultContent' => 'NULL','name' => 'email_id', 'data' => 'email_id'],
            'status_id' => ['defaultContent' => 'NULL','name' => 'status', 'data' => 'status']
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
