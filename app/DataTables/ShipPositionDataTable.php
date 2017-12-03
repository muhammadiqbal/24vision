<?php

namespace App\DataTables;

use App\Models\ShipPosition;
use Form;
use Yajra\DataTables\Services\DataTable;

class ShipPositionDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'ship_positions.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $shipPositions = ShipPosition::with('ship')->with('region')->with('port')->select('ship_positions.*');

        return $this->applyScopes($shipPositions);
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
            'ship' => ['name' => 'ship.name', 'data' => 'ship.name'],
            'region' => ['name' => 'region.name', 'data' => 'region.name'],
            'port' => ['name' => 'port.name', 'data' => 'port.name'],
            'date_of_opening' => ['name' => 'date_of_opening', 'data' => 'date_of_opening']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'shipPositions';
    }
}
