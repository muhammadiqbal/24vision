<?php

namespace App\DataTables;

use App\Models\BdiPrice;
use Form;
use Yajra\DataTables\Services\DataTable;

class BdiPriceDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'bdi_prices.datatables_actions')
            ->editColumn('start_date', function(BdiPrice $bdiPrices){
               return date_format(date_create($bdiPrices->start_date),'d-m-Y');
            })
            ->editColumn('end_date', function(BdiPrice $bdiPrices){
               return date_format(date_create($bdiPrices->end_date),'d-m-Y');
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
        $bdiPrices = BdiPrice::with('bdi')->select('bdi_prices.*');

        return $this->applyScopes($bdiPrices);
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
            'bdi' => ['name' => 'bdi.code', 'data' => 'bdi.code'],
            'price' => ['name' => 'price', 'data' => 'price'],
            'start_date' => ['name' => 'start_date', 'data' => 'start_date'],
            'end_date' => ['name' => 'end_date', 'data' => 'end_date']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'bdiPrices';
    }
}
