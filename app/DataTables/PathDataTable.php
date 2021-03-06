<?php

namespace App\DataTables;

use App\Models\Path;
use Form;
use Yajra\DataTables\Services\DataTable;

class PathDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'paths.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $paths = Path::leftjoin('zones as z1','zone1','z1.id')
                     ->leftjoin('zones as z2','zone2','z2.id')
                     ->leftjoin('zones as z3','zone3','z3.id')
                     ->leftjoin('routes','route_id','routes.id')
                     ->select('paths.*','z1.name as zon1', 'z2.name as zon2', 'z3.name as zon3', 'routes.name as route');

        return $this->applyScopes($paths);
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
            'route_id' => ['name' => 'route', 'data' => 'route','searchable'=>false],
            'zone1' => ['name' => 'zon1', 'data' => 'zon1','searchable'=>false],
            'zone2' => ['name' => 'zon2', 'data' => 'zon2','searchable'=>false],
            'zone3' => ['name' => 'zon3', 'data' => 'zon3','searchable'=>false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'paths';
    }
}
