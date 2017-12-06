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
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $cargos = Cargo::query();

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
                'scrollX' => false,
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
                ]
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
            'customer_id' => ['name' => 'customer_id', 'data' => 'customer_id'],
            'loading_port' => ['name' => 'loading_port', 'data' => 'loading_port'],
            'discharging_port' => ['name' => 'discharging_port', 'data' => 'discharging_port'],
            'laycan_first_day' => ['name' => 'laycan_first_day', 'data' => 'laycan_first_day'],
            'laycan_last_day' => ['name' => 'laycan_last_day', 'data' => 'laycan_last_day'],
            'cargo_description' => ['name' => 'cargo_description', 'data' => 'cargo_description'],
            'stowage_factor' => ['name' => 'stowage_factor', 'data' => 'stowage_factor'],
            'sf_unit' => ['name' => 'sf_unit', 'data' => 'sf_unit'],
            'ship_specialization_id' => ['name' => 'ship_specialization_id', 'data' => 'ship_specialization_id'],
            'quantity_measurement_id' => ['name' => 'quantity_measurement_id', 'data' => 'quantity_measurement_id'],
            'quantity' => ['name' => 'quantity', 'data' => 'quantity'],
            'loading_rate_type' => ['name' => 'loading_rate_type', 'data' => 'loading_rate_type'],
            'loading_rate' => ['name' => 'loading_rate', 'data' => 'loading_rate'],
            'discharging_rate_type' => ['name' => 'discharging_rate_type', 'data' => 'discharging_rate_type'],
            'discharging_rate' => ['name' => 'discharging_rate', 'data' => 'discharging_rate'],
            'freight_idea_measurement_id' => ['name' => 'freight_idea_measurement_id', 'data' => 'freight_idea_measurement_id'],
            'freight_idea' => ['name' => 'freight_idea', 'data' => 'freight_idea'],
            'extra_condition' => ['name' => 'extra_condition', 'data' => 'extra_condition'],
            'comission' => ['name' => 'comission', 'data' => 'comission']
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
