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
            'loading_port' => ['name' => 'loading_port', 'data' => 'loading_port'],
            //'loading_port_manual' => ['name' => 'loading_port_manual', 'data' => 'loading_port_manual'],
            'discharging_port' => ['name' => 'discharging_port', 'data' => 'discharging_port'],
            //'discharging_port_manual' => ['name' => 'discharging_port_manual', 'data' => 'discharging_port_manual'],
            'laycan_first_day' => ['name' => 'laycan_first_day', 'data' => 'laycan_first_day'],
            //'laycan_first_day_manual' => ['name' => 'laycan_first_day_manual', 'data' => 'laycan_first_day_manual'],
            'laycan_last_day' => ['name' => 'laycan_last_day', 'data' => 'laycan_last_day'],
            //'laycan_last_day_manual' => ['name' => 'laycan_last_day_manual', 'data' => 'laycan_last_day_manual'],
            'cargo_type_id' => ['name' => 'cargo_type_id', 'data' => 'cargo_type_id'],
            //'cargo_type_id_manual' => ['name' => 'cargo_type_id_manual', 'data' => 'cargo_type_id_manual'],
            'stowage_factor' => ['name' => 'stowage_factor', 'data' => 'stowage_factor'],
            //'stowage_factor_manual' => ['name' => 'stowage_factor_manual', 'data' => 'stowage_factor_manual'],
            //'sf_unit' => ['name' => 'sf_unit', 'data' => 'sf_unit'],
            //'sf_unit_manual' => ['name' => 'sf_unit_manual', 'data' => 'sf_unit_manual'],
            'ship_specialization_id' => ['name' => 'ship_specialization_id', 'data' => 'ship_specialization_id'],
            //'ship_specialization_id_manual' => ['name' => 'ship_specialization_id_manual', 'data' => 'ship_specialization_id_manual'],
            'quantity_measurement_id' => ['name' => 'quantity_measurement_id', 'data' => 'quantity_measurement_id'],
            //'quantity_measurement_id_manual' => ['name' => 'quantity_measurement_id_manual', 'data' => 'quantity_measurement_id_manual'],
            'quantity' => ['name' => 'quantity', 'data' => 'quantity'],
            //'quantity_manual' => ['name' => 'quantity_manual', 'data' => 'quantity_manual'],
            //'loading_rate_type' => ['name' => 'loading_rate_type', 'data' => 'loading_rate_type'],
            //'loading_rate_type_manual' => ['name' => 'loading_rate_type_manual', 'data' => 'loading_rate_type_manual'],
            'loading_rate' => ['name' => 'loading_rate', 'data' => 'loading_rate'],
            //'loading_rate_manual' => ['name' => 'loading_rate_manual', 'data' => 'loading_rate_manual'],
            //'discharging_rate_type' => ['name' => 'discharging_rate_type', 'data' => 'discharging_rate_type'],
            //'discharging_rate_type_manual' => ['name' => 'discharging_rate_type_manual', 'data' => 'discharging_rate_type_manual'],
            'discharging_rate' => ['name' => 'discharging_rate', 'data' => 'discharging_rate'],
            //'discharging_rate_manual' => ['name' => 'discharging_rate_manual', 'data' => 'discharging_rate_manual'],
            'extra_condition' => ['name' => 'extra_condition', 'data' => 'extra_condition'],
            //'extra_condition_manual' => ['name' => 'extra_condition_manual', 'data' => 'extra_condition_manual'],
            'comission' => ['name' => 'comission', 'data' => 'comission'],
            //'commision_manual' => ['name' => 'commision_manual', 'data' => 'commision_manual'],
            'emailId' => ['name' => 'emailId', 'data' => 'emailId'],
            //'emailId_manual' => ['name' => 'emailId_manual', 'data' => 'emailId_manual'],
            'status_id' => ['name' => 'status_id', 'data' => 'status_id'],
            //'status_id_manual' => ['name' => 'status_id_manual', 'data' => 'status_id_manual']
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
