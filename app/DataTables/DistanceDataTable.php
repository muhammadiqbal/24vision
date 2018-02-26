<?php

namespace App\DataTables;

use App\Models\Distance;
use Form;
use Yajra\DataTables\Services\DataTable;

class DistanceDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'distances.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $distances = Distance::leftjoin('ports as p1', 'p1.id','start_port')
                        ->leftjoin('ports as p2', 'p2.id','end_port')
                        ->select('distances.*', 'p1.name as start', 'p2.name as end');

        return $this->applyScopes($distances);
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
            'start_port' => ['name' => 'start_port', 'data' => 'start'],
            'end_port' => ['name' => 'end_port', 'data' => 'end'],
            'distance' => ['name' => 'distance', 'data' => 'distance']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'distances';
    }
}
