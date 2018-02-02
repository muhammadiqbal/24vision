<?php

namespace App\DataTables;

use App\Models\Cargo;
use Yajra\DataTables\Services\DataTable;

class DashboardDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'calculator.datatables_actions')
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
                        ->select('cargos.*','cargo_status.name as status','cargo_types.name as type', 'p1.name', 'p2.name');
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
            'loading_port' => ['defaultContent' => 'NULL','name' => 'loading_port', 'data' => 'loading_port'],
            'discharging_port' => ['defaultContent' => 'NULL','name' => 'discharging_port', 'data' => 'discharging_port'],
            'email_id' => ['defaultContent' => 'NULL','name' => 'email_id', 'data' => 'email_id'],
            'status_id' => ['defaultContent' => 'NULL','name' => 'status', 'data' => 'status'],
            'distance_to_start'=>['defaultContent' => 'NULL','name'=>'','data' => ''],
            'route'=>['defaultContent' => 'NULL','name'=>'','data' => ''],
            'bdi'=>['defaultContent' => 'NULL','name'=>'','data' => ''],
            'gross_rate'=>['defaultContent' => 'NULL','name'=>'','data' => ''],
            'ntce'=>['defaultContent' => 'NULL','name'=>'ntce','data' => 'ntce']
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
